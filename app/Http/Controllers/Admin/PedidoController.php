<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedidoArma;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Lista todos os pedidos com filtros
     */
        public function index()
    {
        // Listagem cronológica e paginada
        $pedidos = PedidoArma::with(['associado', 'modelo'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function aprovar($id)
    {
        DB::transaction(function () use ($id) {
            $pedido = PedidoArma::findOrFail($id);
            
            if ($pedido->status_pedido !== 'iniciado') {
                return back()->with('erro', 'Este pedido já foi processado.');
            }

            // 1. Baixa no estoque
            $arma = ModeloArma::findOrFail($pedido->modelo_id);
            if ($arma->quantidade > 0) {
                $arma->decrement('quantidade');
            } else {
                throw new \Exception("Estoque insuficiente para este modelo.");
            }

            // 2. Atualiza status
            $pedido->update(['status_pedido' => 'pago']); // Ou 'aprovado'
        });

        return back()->with('success', 'Pedido aprovado e estoque atualizado!');
    }

    public function arquivar(Request $request, $id)
    {
        $pedido = PedidoArma::findOrFail($id);
        
        $pedido->update([
            'status_pedido' => 'concluido', // Usamos concluído como arquivado
            'observacao_admin' => $request->observacao_admin
        ]);

        return back()->with('success', 'Pedido arquivado com sucesso.');
    }

    public function destroy($id)
    {
        $pedido = PedidoArma::findOrFail($id);
        // Exclusão não mexe no estoque conforme solicitado
        $pedido->delete();
        return back()->with('success', 'Requerimento excluído permanentemente.');
    }

    /**
     * Exibe os detalhes de um pedido específico
     */
    public function show($id)
    {
        $pedido = PedidoArma::with(['associado.endereco', 'modelo'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Atualiza o status do pedido (O que o Adriano/Marcos mais farão)
     */
    public function update(Request $request, $id)
    {
        $pedido = PedidoArma::findOrFail($id);
        
        $pedido->update([
            'status_pedido' => $request->status_pedido,
        ]);

        return back()->with('success', 'Status do pedido atualizado com sucesso!');
    }
}