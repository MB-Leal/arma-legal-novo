<?php

namespace App\Http\Controllers;

use App\Models\ModeloArma;
use App\Models\PedidoArma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Associado;
use Illuminate\Support\Facades\Session;

class PedidoArmaController extends Controller
{
    /**
     * Exibe o catálogo de armas disponíveis para o associado
     */
    public function vitrine()
    {
        $nomeAssociado = Session::get('associado_nome');
        $modelos = ModeloArma::with('imagens')->get();
        return view('associado.catalogo', compact('modelos', 'nomeAssociado'));
    }

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
        // Busca o pedido com todas as relações para evitar erros de "null" no PDF
        $pedido = PedidoArma::with(['associado.endereco', 'modelo.fabricante', 'modelo.calibre'])
            ->findOrFail($id);

        // Dados que vão preencher as variáveis no Blade do PDF
        $dados = [
            'pedido'    => $pedido,
            'associado' => $pedido->associado,
            'arma'      => $pedido->modelo,
            'data'      => now()->format('d/m/Y'),
        ];

        // Carrega a view específica do PDF
        $pdf = Pdf::loadView('associado.pdf_requerimento', $dados);

        // Faz o download automático com o nome do associado e CPF
        return $pdf->download("Requerimento_{$pedido->associado->cpf}.pdf");
    }

    // 2. Exibe os detalhes de uma arma específica
    public function showDetalhes($id)
    {
        $modelo = ModeloArma::with('imagens')->findOrFail($id);
        return view('associado.detalhes', compact('modelo'));
    }

    // 3. Abre o simulador para a arma escolhida
    public function showSimulador($id)
    {
        $modelo = ModeloArma::findOrFail($id);
        return view('associado.simulador', compact('modelo'));
    }

    // 4. Etapa de confirmação/preenchimento de endereço (Onde entra o ViaCEP)
    public function confirmarDados($modelo_id, Request $request)
    {
        $associado = Associado::with('endereco')->find(session('associado_id'));
        $modelo = ModeloArma::findOrFail($modelo_id);
        $parcelas = $request->query('parcelas', 1);

        return view('associado.confirmar', compact('associado', 'modelo', 'parcelas'));
    }

    // 5. Salva/Atualiza endereço e cria o pedido final
    public function finalizarPedido(Request $request)
    {
        $associado = Associado::find(session('associado_id'));

        // 1. Atualiza dados do militar
        $associado->update([
            'posto_graduacao' => $request->posto_graduacao,
            'opm' => $request->opm
        ]);

        // 2. Atualiza ou Cria o Endereço (Resolve o problema dos dados NULOS)
        $associado->endereco()->updateOrCreate(
            ['associado_id' => $associado->id],
            [
                'cep' => preg_replace('/[^0-9]/', '', $request->cep),
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'complemento' => $request->complemento,
            ]
        );

        // 3. Cria o Pedido
        $pedido = PedidoArma::create([
            'associado_id' => $associado->id,
            'modelo_id' => $request->modelo_id,
            'status_pedido' => 'iniciado',
            'data_pedido' => now(),
            'parcelas' => $request->parcelas // Certifique-se de ter este campo na migration
        ]);

        return redirect()->route('associado.sucesso', $pedido->id);
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
}
