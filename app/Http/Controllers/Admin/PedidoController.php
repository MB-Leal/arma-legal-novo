<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedidoArma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Lista todos os pedidos com filtros
     */
    public function index()
    {
        $pedidos = PedidoArma::has('modelo')
            ->with(['associado' => function ($q) {
                $q->withTrashed();
            }, 'modelo'])
            ->where('status_pedido', '!=', 'arquivado')
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
    $statusAntigo = $pedido->status_pedido;
    $novoStatus = $request->status_pedido;

    try {
        DB::transaction(function () use ($pedido, $statusAntigo, $novoStatus) {
            
            // LÓGICA DE ESTOQUE:
            // Só subtrai se o novo status for 'lançado em folha' AND o antigo NÃO era
            if ($novoStatus === 'lançado em folha' && $statusAntigo !== 'lançado em folha') {
                $modelo = $pedido->modelo;

                if ($modelo && $modelo->quantidade > 0) {
                    $modelo->decrement('quantidade', 1);
                } else {
                    // Lança uma exceção para interromper a transação se não houver estoque
                    throw new \Exception("Estoque insuficiente para o modelo: " . ($modelo->nome ?? 'Desconhecido'));
                }
            }           

            $pedido->status_pedido = $novoStatus;
            $pedido->save();
        });

        return redirect()->back()->with('success', 'Status atualizado e estoque baixado com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['erro' => $e->getMessage()]);
    }
}

    public function arquivar(Request $request, $id)
    {
        // 1. Validação da justificativa
        $request->validate([
            'observacao_admin' => 'required|string|min:5'
        ]);

        // 2. Busca o pedido
        $pedido = \App\Models\PedidoArma::findOrFail($id);

        // 3. Atualiza o status e salva a observação
        $pedido->update([
            'status_pedido' => 'arquivado', // Ou 'arquivado', conforme sua regra de negócio
            'observacao_admin' => $request->observacao_admin
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Requerimento arquivado com sucesso!');
    }
}
