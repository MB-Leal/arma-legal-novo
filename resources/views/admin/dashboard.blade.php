@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Painel de Controle</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Resumo geral de atividades do sistema</p>
        </div>
        <div class="text-slate-400 text-xs font-bold uppercase">
            {{ date('d/m/Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i class="fa-solid fa-file-invoice"></i></div>
            </div>
            <span class="text-[10px] font-black text-slate-400 uppercase">Total de Pedidos</span>
            <div class="text-3xl font-black text-slate-800 leading-none mt-1">{{ $stats['total_pedidos'] ?? 0 }}</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg"><i class="fa-solid fa-clock"></i></div>
            </div>
            <span class="text-[10px] font-black text-slate-400 uppercase">Pedidos Iniciados</span>
            <div class="text-3xl font-black text-slate-800 leading-none mt-1">{{ $stats['pedidos_novos'] ?? 0 }}</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-green-50 text-green-600 rounded-lg"><i class="fa-solid fa-hand-holding-dollar"></i></div>
            </div>
            <span class="text-[10px] font-black text-slate-400 uppercase">Volume (Est. 10%)</span>
            <div class="text-xl font-black text-slate-800 leading-none mt-1">R$ {{ number_format($stats['volume_total'] ?? 0, 2, ',', '.') }}</div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg"><i class="fa-solid fa-users"></i></div>
            </div>
            <span class="text-[10px] font-black text-slate-400 uppercase">Total Associados</span>
            <div class="text-3xl font-black text-slate-800 leading-none mt-1">{{ $stats['total_associados'] ?? 0 }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-black text-slate-700 uppercase tracking-tighter text-sm">Últimos Pedidos Realizados</h3>
            <a href="{{ route('pedidos.index') }}" class="text-[10px] font-black text-blue-900 uppercase hover:underline">Ver todos</a>
        </div>
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Militar</th>
                    <th class="px-6 py-4">Modelo</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Data</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pedidosRecentes as $pedido)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-800 uppercase leading-none">{{ $pedido->associado->nome_completo }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase mt-1">CPF: {{ $pedido->associado->cpf }}</div>
                    </td>
                    <td class="px-6 py-4 text-xs font-bold text-blue-900 uppercase">{{ $pedido->modelo->nome }}</td>
                    <td class="px-6 py-4 text-[10px]">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 font-black rounded uppercase">
                            {{ str_replace('_', ' ', $pedido->status_pedido) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-500 font-semibold">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-bold uppercase text-xs tracking-widest italic">Nenhum pedido recente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection