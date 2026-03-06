@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.usuarios.index') }}" class="text-slate-400 hover:text-blue-900 text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Voltar para a Lista
        </a>
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mt-4">Novo Usuário Admin</h1>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nome Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-sm font-bold outline-none focus:border-blue-900 transition">
                @error('name') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">E-mail de Acesso</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-sm font-bold outline-none focus:border-blue-900 transition">
                @error('email') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Senha</label>
                    <input type="password" name="password" required
                        class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-sm font-bold outline-none focus:border-blue-900 transition">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-slate-50 border border-slate-200 p-3 rounded-xl text-sm font-bold outline-none focus:border-blue-900 transition">
                </div>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                <label class="flex items-center cursor-pointer gap-3">
                    <input type="hidden" name="is_admin" value="0">

                    <input type="checkbox" name="is_admin" value="1"
                        {{ old('is_admin') ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-900 border-slate-300 rounded focus:ring-blue-900">

                    <div>
                        <span class="block text-xs font-black text-slate-800 uppercase">Privilégios de Administrador</span>
                        <span class="block text-[10px] text-slate-400 font-bold uppercase">Marque apenas se este usuário puder gerenciar o sistema</span>
                    </div>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-black py-4 rounded-xl text-xs uppercase shadow-lg hover:bg-blue-800 transition">
                Criar Usuário
            </button>
        </form>
    </div>
</div>
@endsection