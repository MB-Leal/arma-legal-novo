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
        // Estatísticas para os Cards
        $stats = [
            'total_pedidos'   => PedidoArma::count(),
            'total_associados' => Associado::count(),
            'pedidos_novos'   => PedidoArma::where('status_pedido', 'iniciado')->count(),
            // Soma o preço base + 10% (estimativa de volume financeiro parcelado)
            'volume_total'    => PedidoArma::join('modelos_armas', 'pedidos_armas.modelo_id', '=', 'modelos_armas.id')
                                            ->sum('modelos_armas.preco') * 1.10
        ];

        // Últimos 10 pedidos para a tabela
        $pedidosRecentes = PedidoArma::with(['associado', 'modelo'])
                                    ->orderBy('created_at', 'desc')
                                    ->take(10)
                                    ->get();

        return view('admin.dashboard', compact('stats', 'pedidosRecentes'));
    }
}