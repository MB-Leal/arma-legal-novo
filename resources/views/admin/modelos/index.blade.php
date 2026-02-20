@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Modelos de Armas</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Gerenciamento do catálogo disponível para os associados</p>
        </div>
        <a href="{{ route('modelos.create') }}" 
           class="inline-flex items-center bg-blue-900 hover:bg-blue-800 text-white font-black py-3 px-6 rounded-xl shadow-lg transition uppercase tracking-widest text-xs">
            <i class="fa-solid fa-plus mr-2"></i> Adicionar Novo Modelo
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Modelo / Nome</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fabricante</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Calibre</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Quantidade</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Preço Base</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($modelos as $modelo)
                    <tr class="hover:bg-slate-50/50 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800 uppercase leading-none">{{ $modelo->nome }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-1">Código: {{ $modelo->codigo }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-600 uppercase">{{ $modelo->fabricante }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase border border-slate-200">
                                {{ $modelo->calibre }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-bold text-slate-600 uppercase">{{ $modelo->quantidade }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-black text-blue-900">
                                R$ {{ number_format($modelo->preco, 2, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('modelos.edit', $modelo->id) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                   title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('modelos.destroy', $modelo->id) }}" method="POST" 
                                      onsubmit="return confirm('Deseja realmente excluir este modelo? Esta ação não pode ser desfeita.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Excluir">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-box-open text-slate-200 text-4xl mb-4"></i>
                                <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Nenhum modelo cadastrado no sistema.</p>
                                <a href="{{ route('modelos.create') }}" class="text-blue-900 text-[10px] font-black uppercase mt-2 hover:underline">Cadastrar o primeiro agora</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection