<?php

namespace App\Http\Controllers;

use App\Models\ModeloArma;
use App\Models\PedidoArma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TaxaParcelamento;
use App\Models\Associado;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PedidoArmaController extends Controller
{
    /**
     * Exibe o catálogo de armas disponíveis para o associado
     */
    public function vitrine()
    {
        $nomeAssociado = Session::get('associado_nome');

        // FILTRO: Só traz para o catálogo armas com estoque disponível
        $modelos = ModeloArma::with('imagens')
            ->where('quantidade', '>', 0)
            ->orderBy('nome')
            ->get();

        return view('associado.catalogo', compact('modelos', 'nomeAssociado'));
    }


    public function meusPedidos()
    {
        $pedidos = PedidoArma::with('modelo')
            ->where('associado_id', session('associado_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('associado.pedidos', compact('pedidos'));
    }
    /**
     * Gera o PDF do Requerimento preenchido
     */

    /*
    public function gerarPDF($pedido_id)
    {
        // 1. Busca o pedido com todos os dados relacionados
        $pedido = PedidoArma::with(['associado.endereco', 'modelo.fabricante', 'modelo.calibre'])
            ->findOrFail($pedido_id);

        // 2. Prepara os dados para a view do PDF
        $data = [
            'pedido' => $pedido,
            'associado' => $pedido->associado,
            'arma' => $pedido->modelo,
            'data_extenso' => now()->translatedFormat('d \d\e F \d\e Y')
        ];

        // 3. Carrega a view e gera o PDF
        $pdf = Pdf::loadView('associado.pdf_requerimento', $data);

        // 4. Retorna o PDF para download ou visualização
        return $pdf->stream("requerimento_{$pedido->associado->cpf}.pdf");
    } */
    /**
     * Registra a intenção de compra (Pedido)
     */
    public function store(Request $request)
    {
        $pedido = PedidoArma::create([
            'associado_id' => Session::get('associado_id'),
            'modelo_id'    => $request->modelo_id,
            'status_pedido' => 'iniciado',
            'data_pedido'   => now()
        ]);

        return redirect()->route('associado.pedido')
            ->with('success', 'A sua intenção de compra foi registada com sucesso!');
    }


    public function gerarRequerimento($id)
    {
        $pedido = PedidoArma::with(['associado.endereco', 'modelo'])->findOrFail($id);

        // Verifica se o pedido pertence ao associado logado (segurança)
        if ($pedido->associado_id != session('associado_id')) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.requerimento', compact('pedido'));

        // Nome do arquivo: Requerimento_NOME_DATA.pdf
        $filename = 'Requerimento_' . str_replace(' ', '_', $pedido->associado->nome_completo) . '.pdf';

        return $pdf->stream($filename);
    }
    // 2. Exibe os detalhes de uma arma específica
    public function showDetalhes($id)
    {
        $modelo = ModeloArma::with('imagens')->findOrFail($id);
        return view('associado.detalhes', compact('modelo'));
    }

    // 3. Abre o simulador para a arma escolhida


    // 4. Etapa de confirmação/preenchimento de endereço (Onde entra o ViaCEP)
    public function confirmarDados($modelo_id, Request $request)
    {
        $associado = Associado::with('endereco')->find(session('associado_id'));
        $modelo = ModeloArma::findOrFail($modelo_id);
        $parcelas = $request->query('parcelas', 1);

        return view('associado.confirmar', compact('associado', 'modelo', 'parcelas'));
    }

    // 6. Lista os pedidos do associado (CORREÇÃO DO ERRO 500)
    public function meuPedido()
    {
        $pedidos = PedidoArma::with('modelo')
            ->where('associado_id', Session::get('associado_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('associado.pedidos', compact('pedidos'));
    }
    public function sucesso($id)
    {
        // Busca o pedido garantindo que pertença ao associado logado por segurança
        $pedido = PedidoArma::with('modelo')
            ->where('associado_id', session('associado_id'))
            ->findOrFail($id);

        return view('associado.sucesso', compact('pedido'));
    }
    public function showSimulador($id)
    {
        $modelo = ModeloArma::with('imagens')->findOrFail($id);

        // Agora lendo da tabela taxas_parcelamento via Model
        $taxas = TaxaParcelamento::orderBy('parcela')->pluck('percentual', 'parcela');

        // Fallback caso a tabela esteja vazia
        if ($taxas->isEmpty()) {
            for ($i = 1; $i <= 24; $i++) {
                $taxas->put($i, $i * 0.0090);
            }
        }

        return view('associado.simulador', compact('modelo', 'taxas'));
    }

    public function conferirDados(Request $request)
    {
        $modelo = ModeloArma::with('imagens')->findOrFail($request->modelo_id);
        $parcelas = $request->parcelas;
        $associado = Associado::with('endereco')->findOrFail(session('associado_id'));

        $taxaObj = TaxaParcelamento::where('parcela', $parcelas)->first();
        $percentual = $taxaObj ? $taxaObj->percentual : ($parcelas * 0.0090);
        $valor_total = $modelo->preco * (1 + $percentual);

        // --- CORREÇÃO: Definindo a variável ANTES de passar para a view ---
        $valor_parcela = $valor_total / $parcelas;

        return view('associado.conferir', compact('modelo', 'parcelas', 'valor_parcela', 'associado', 'valor_total'));
    }

    public function finalizarPedido(Request $request)
    {
        $pedido_id = DB::transaction(function () use ($request) {
            $associado = Associado::findOrFail(session('associado_id'));

            // 1. Atualiza Associado
            $associado->update($request->only(['rg_militar', 'posto_graduacao', 'opm', 'email', 'celular', 'status']));

            // 2. Atualiza Endereço
            $dadosEndereco = $request->only(['cep', 'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'complemento']);
            $dadosEndereco['cep'] = preg_replace('/\D/', '', $dadosEndereco['cep']);
            $associado->endereco()->update($dadosEndereco);

            // --- CORREÇÃO DA LIMPEZA DOS VALORES ---
            $limparMoeda = function ($valor) {
                if (empty($valor)) return 0;
                // Se tem vírgula, é formato BR (1.234,56). Removemos o ponto e trocamos a vírgula por ponto.
                if (strpos($valor, ',') !== false) {
                    return (float) str_replace(',', '.', str_replace('.', '', $valor));
                }
                // Se não tem vírgula, já deve estar no formato decimal (5314.5)
                return (float) $valor;
            };

            $vTotal = $limparMoeda($request->valor_total);
            $vParcela = $limparMoeda($request->valor_parcela);

            // 4. Cria o Pedido com os valores corrigidos
            $pedido = PedidoArma::create([
                'associado_id' => $associado->id,
                'modelo_id'    => $request->modelo_id,
                'valor_total'  => $vTotal,
                'valor_parcela' => $vParcela,
                'parcelas'     => $request->parcelas,
                'status_pedido' => 'iniciado',
                'data_pedido'  => now(),
            ]);

            return $pedido->id;
        });

        return redirect()->route('associado.pdf', $pedido_id);
    }
}
