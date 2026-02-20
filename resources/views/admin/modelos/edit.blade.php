@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Editar Modelo: {{ $modelo->nome }}</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Atualize as informações técnicas ou o preço</p>
        </div>
    </div>

    <form action="{{ route('modelos.update', $modelo->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Nome Comercial</label>
                    <input type="text" name="nome" value="{{ $modelo->nome }}" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none uppercase font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Fabricante</label>
                    <input type="text" name="fabricante" value="{{ $modelo->fabricante }}" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none uppercase font-bold text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Calibre</label>
                    <input type="text" name="calibre" value="{{ $modelo->calibre }}" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Capacidade</label>
                    <input type="text" name="capacidade" value="{{ $modelo->capacidade }}" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-2">Preço Base (R$)</label>
                    <input type="number" step="0.01" name="preco" value="{{ $modelo->preco }}" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm">
                </div>
            </div>

            <div class="pt-4">
                <label class="block text-xs font-black text-slate-500 uppercase mb-2">Trocar Foto (Opcional)</label>
                <div class="flex items-center space-x-4">
                    @if($modelo->imagens->where('principal', true)->first())
                        <img src="{{ asset('storage/' . $modelo->imagens->where('principal', true)->first()->caminho) }}" class="h-20 w-20 object-cover rounded-lg border">
                    @endif
                    <input type="file" name="foto" class="text-xs">
                </div>
            </div>
        </div>

        <div class="bg-slate-50 p-6 flex justify-between items-center">
            <a href="{{ route('modelos.index') }}" class="text-xs font-black text-slate-400 uppercase">Voltar</a>
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-black py-4 px-10 rounded-xl shadow-lg transition uppercase tracking-widest text-xs">
                Atualizar Modelo
            </button>
        </div>
    </form>
</div>
@endsection