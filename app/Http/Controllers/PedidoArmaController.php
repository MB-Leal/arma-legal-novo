<?php

namespace App\Http\Controllers;

use App\Models\ModeloArma;
use App\Models\PedidoArma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TaxaParcelamento;

class PedidoArmaController extends Controller
{
    /**
     * Exibe o catálogo de armas disponíveis para o associado
     */
    public function vitrine()
    {
        // Pegamos o nome da sessão para saudar o associado
        $nomeAssociado = Session::get('associado_nome');

        // Buscamos os modelos de armas com suas imagens
        $modelos = ModeloArma::with('imagens')->get();

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

    public function gerarRequerimento($id)
    {
        // Busca o pedido com todas as relações para evitar erros de "null" no PDF
        $pedido = PedidoArma::with(['associado.endereco', 'modelo'])
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
    public function showSimulador($id)
    {
        $modelo = ModeloArma::findOrFail($id);

        // BUSCA AS TAXAS: Cria um array onde a chave é a parcela e o valor é o percentual
        // Ex: [1 => 0.0090, 2 => 0.0136, ...]
        $taxas = TaxaParcelamento::pluck('percentual', 'parcela');

        return view('associado.simulador', compact('modelo', 'taxas'));
    }
    public function finalizarPedido(Request $request)
{
    // 1. Busca os dados oficiais no Banco (Segurança)
    $modelo = ModeloArma::findOrFail($request->modelo_id);
    
    // 2. Busca a taxa exata para a parcela escolhida
    $taxaDigital = TaxaParcelamento::where('parcela', $request->parcelas)->first();
    
    if (!$taxaDigital) {
        return back()->with('erro', 'Opção de parcelamento inválida.');
    }

    // 3. CÁLCULO DINÂMICO (Preço Base + Taxa)
    // Ex: 5.400,00 * (1 + 0.0629) = 5.739,66
    $valorTotalCalculado = $modelo->preco * (1 + $taxaDigital->percentual);

    // 4. Grava o pedido com o valor total final "congelado"
    $pedido = PedidoArma::create([
        'associado_id' => session('associado_id'),
        'modelo_id'    => $modelo->id,
        'parcelas'     => $request->parcelas,
        'valor_total'  => $valorTotalCalculado, // Valor exato que você simulou
        'status_pedido' => 'iniciado',
        'data_pedido'  => now()
    ]);

    return redirect()->route('associado.sucesso', $pedido->id);
}
}
