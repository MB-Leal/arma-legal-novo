@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Associados</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Militares cadastrados no programa</p>
        </div>
        <a href="{{ route('associados.create') }}" class="bg-blue-900 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-800 transition shadow-lg">
            Novo Associado
        </a>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
        <form action="{{ route('associados.index') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por Nome ou CPF..."
                class="flex-grow p-3 bg-slate-50 border-2 border-slate-100 rounded-lg outline-none focus:border-blue-900 font-bold text-sm transition">
            <button type="submit" class="bg-slate-800 text-white px-6 rounded-lg font-black text-xs uppercase">Filtrar</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Nome / CPF</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Matrícula</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Posto / OPM</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Status</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($associados as $asso)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-4">
                        <div class="font-black text-slate-700 text-sm uppercase">{{ $asso->nome_completo }}</div>
                        <div class="text-[10px] text-slate-400 font-bold">{{ $asso->cpf }}</div>
                    </td>
                    <td class="p-4 text-center font-bold text-xs text-slate-500">{{ $asso->matricula }}</td>
                    <td class="p-4 text-center">
                        <div class="text-xs font-black text-slate-700 uppercase">{{ $asso->posto_graduacao }}</div>
                        <div class="text-[9px] text-slate-400 font-bold uppercase">{{ $asso->opm }}</div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase {{ $asso->status == 'ativo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $asso->status }}
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('associados.edit', $asso->id) }}" class="text-blue-600 hover:text-blue-900"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('associados.destroy', $asso->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este associado?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        @if($asso->trashed())
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase">Excluído</span>

                        <form action="{{ route('admin.associados.restore', $asso->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-800 font-black text-[10px] uppercase ml-2" title="Reativar Militar">
                                <i class="fa-solid fa-trash-arrow-up"></i> Reativar
                            </button>
                        </form>
                        @else
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">Ativo</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $associados->appends(['search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection