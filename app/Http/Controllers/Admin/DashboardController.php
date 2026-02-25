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
            // Calcula o volume total (soma dos valores dos pedidos)
            'volume_total'     => PedidoArma::sum('valor_total') ?? 0,
        ];

        // 2. Busca os últimos 10 pedidos com os relacionamentos carregados
        // Importante: use 'with' para não dar erro de 'property of non-object'
        $pedidosRecentes = PedidoArma::with(['associado', 'modelo'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pedidosRecentes'));
    }
}