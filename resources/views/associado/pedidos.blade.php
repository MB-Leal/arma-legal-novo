@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-black text-blue-900 uppercase mb-6 flex items-center">
        <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
        Histórico de Pedidos
    </h2>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Data</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Modelo</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Nº de Série</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pedidos as $pedido)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                        {{ $pedido->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="block text-sm font-bold text-blue-900 uppercase">{{ $pedido->modelo->nome }}</span>
                        <span class="text-xs text-slate-400 uppercase">{{ $pedido->modelo->fabricante }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $cores = [
                        'iniciado' => 'bg-blue-100 text-blue-700',
                        'pago' => 'bg-green-100 text-green-700',
                        'em_fabricacao' => 'bg-yellow-100 text-yellow-700',
                        'cancelado' => 'bg-red-100 text-red-700'
                        ];
                        $cor = $cores[$pedido->status_pedido] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $cor }}">
                            {{ str_replace('_', ' ', $pedido->status_pedido) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-mono text-slate-500">
                        {{ $pedido->numero_serie ?? '---' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 uppercase font-bold">
                        Nenhum pedido encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection