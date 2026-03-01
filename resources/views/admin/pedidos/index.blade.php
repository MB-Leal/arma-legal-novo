@extends('layouts.admin')

@section('content')
{{-- Estilo para evitar que o modal pisque ao carregar a página --}}
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="max-w-6xl mx-auto" x-data="{ modalArquivar: false, actionUrl: '' }">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Gestão de Requerimentos</h1>
        <p class="text-slate-500 text-xs font-bold uppercase">Acompanhamento de intenções de compra</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Data / ID</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Associado</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Arma / Valor</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($pedidos as $pedido)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="text-[10px] font-black text-blue-600">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-[9px] text-slate-400 font-bold">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-xs font-black text-slate-700 uppercase leading-none">{{ $pedido->associado->nome_completo ?? 'Militar não encontrado' }}</div>
                        <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Matrícula: {{ $pedido->associado->matricula ?? '---' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-xs font-bold text-slate-700 uppercase leading-none">{{ $pedido->modelo->nome ?? 'Modelo Removido do Catálogo' }}</div>
                        <div class="text-[10px] text-blue-600 font-black mt-1">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</div>
                    </td>
                    <td class="p-4 text-center">
                        @php
                        $statusCores = [
                            'iniciado' => 'bg-blue-100 text-blue-700',
                            'lançado em folha' => 'bg-green-100 text-green-700',
                            'aguardando sigma' => 'bg-green-100 text-green-700',
                            'concluido' => 'bg-slate-100 text-slate-600',
                            'cancelado' => 'bg-red-100 text-red-700'
                        ];
                        $cor = $statusCores[$pedido->status_pedido] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase {{ $cor }}">
                            {{ str_replace('_', ' ', $pedido->status_pedido) }}
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-slate-400 hover:text-blue-600 transition" title="Ver Detalhes">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <button @click="actionUrl = '{{ route('admin.pedidos.arquivar', $pedido->id) }}'; modalArquivar = true"
                            class="text-slate-400 hover:text-amber-600 transition"
                            title="Arquivar Processo">
                            <i class="fa-solid fa-box-archive"></i>
                        </button>

                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja cancelar este pedido?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-slate-300 hover:text-red-500 transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-slate-50 border-t border-slate-100">
            {{ $pedidos->links() }}
        </div>
    </div>

    <div x-show="modalArquivar"
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl" @click.away="modalArquivar = false">
            <h2 class="text-xl font-black text-slate-800 uppercase mb-4">Arquivar Processo</h2>
            <p class="text-slate-500 text-xs font-bold uppercase mb-6">Insira uma observação para finalizar este requerimento no sistema.</p>

            <form :action="actionUrl" method="POST">
                @csrf
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Observação de Conclusão</label>
                <textarea name="observacao_admin" required rows="4"
                    class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none focus:border-blue-900 text-sm font-bold"
                    placeholder="Ex: Entrega realizada / Financiamento averbado..."></textarea>

                <div class="mt-6 flex justify-end gap-4">
                    <button type="button" @click="modalArquivar = false" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded-xl font-black text-xs uppercase shadow-lg hover:bg-blue-800 transition">
                        Confirmar e Arquivar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection