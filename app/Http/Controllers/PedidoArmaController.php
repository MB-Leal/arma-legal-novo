<?php

namespace App\Http\Controllers;

use App\Models\ModeloArma;
use App\Models\PedidoArma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

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
}
