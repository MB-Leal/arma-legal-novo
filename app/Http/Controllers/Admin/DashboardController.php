<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PedidoArma;
use App\Models\Associado;
use App\Models\ModeloArma;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Estatísticas para os cards
        $stats = [
    'total_pedidos'    => PedidoArma::count(),
    'pedidos_novos'    => PedidoArma::where('status_pedido', 'iniciado')->count(),
    'total_associados' => Associado::count(),
    'volume_total'     => PedidoArma::sum('valor_total') ?? 0,
    
    // NOVO: Soma total de todas as unidades de armas disponíveis em estoque
    'total_estoque'    => \App\Models\ModeloArma::where('quantidade', '>', 0)->sum('quantidade') ?? 0,
];

        // 2. Busca os últimos 10 pedidos com os relacionamentos carregados
        // Importante: use 'with' para não dar erro de 'property of non-object'       
        $pedidosRecentes = PedidoArma::with(['associado' => function ($query) {
            $query->withTrashed(); // Permite carregar o associado mesmo que ele tenha sido deletado
        }, 'modelo'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pedidosRecentes'));
    }
}
