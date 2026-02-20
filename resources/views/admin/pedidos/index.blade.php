@extends('layouts.admin')

@section('content')
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
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-4">
                        <div class="text-xs font-black text-slate-700">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                        <div class="text-[9px] text-slate-400 font-bold uppercase">#{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-xs font-black text-slate-800 uppercase">{{ $pedido->associado->nome_completo }}</div>
                        <div class="text-[9px] text-slate-400 font-bold">{{ $pedido->associado->cpf }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-xs font-bold text-blue-900 uppercase">{{ $pedido->modelo->nome }}</div>
                        <div class="text-xs font-black text-slate-700">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase 
                            {{ $pedido->status_pedido == 'iniciado' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                            {{ $pedido->status_pedido }}
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-1">
                        @if($pedido->status_pedido == 'iniciado')
                        <form action="{{ route('admin.pedidos.aprovar', $pedido->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700" title="Aprovar e Baixar Estoque">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </form>
                        @endif

                        <button @click="actionUrl = '{{ route('admin.pedidos.arquivar', $pedido->id) }}'; modalArquivar = true" 
                                class="bg-blue-900 text-white p-2 rounded-lg hover:bg-slate-800" title="Arquivar">
                            <i class="fa-solid fa-box-archive"></i>
                        </button>

                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir requerimento permanentemente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $pedidos->links() }}
        </div>
    </div>

    <div x-show="modalArquivar" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
            <h2 class="text-xl font-black text-slate-800 uppercase mb-4">Arquivar Processo</h2>
            <form :action="actionUrl" method="POST">
                @csrf
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Observação de Conclusão</label>
                <textarea name="observacao_admin" required rows="4" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none focus:border-blue-900 text-sm" placeholder="Ex: Entrega realizada / Financiamento averbado..."></textarea>
                
                <div class="mt-6 flex justify-end gap-4">
                    <button type="button" @click="modalArquivar = false" class="text-xs font-black text-slate-400 uppercase">Cancelar</button>
                    <button type="submit" class="bg-blue-900 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest">Confirmar Arquivamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection