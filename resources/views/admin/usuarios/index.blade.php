@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Gestão de Usuários Admin</h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase">Controle de acesso ao painel administrativo</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="bg-blue-900 text-white px-6 py-3 rounded-xl text-xs font-black uppercase shadow-lg hover:bg-blue-800 transition">
            <i class="fa-solid fa-plus mr-2"></i> Novo Usuário
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl text-xs font-bold uppercase">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Nome / E-mail</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Nível</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Criado em</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($usuarios as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="text-sm font-black text-slate-800 uppercase">{{ $user->name }}</div>
                        <div class="text-[10px] text-slate-400 font-bold italic">{{ $user->email }}</div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $user->is_admin ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $user->is_admin ? 'Administrador' : 'Usuário Comum' }}
                        </span>
                    </td>
                    <td class="p-4 text-xs font-bold text-slate-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="text-slate-400 hover:text-blue-600 transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @if($user->id !== Auth::id())
                        <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este acesso?')">
                            @csrf @method('DELETE')
                            <button class="text-slate-400 hover:text-red-600 transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection