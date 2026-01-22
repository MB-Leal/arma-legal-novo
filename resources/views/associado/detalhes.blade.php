@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 flex flex-col md:flex-row">

        <div class="md:w-1/2 bg-slate-100 p-8 flex items-center justify-center">
            @if($modelo->imagens->count() > 0)
            <img src="{{ asset('imagens/' . $modelo->imagens->first()->caminho) }}"
                class="max-h-[400px] object-contain drop-shadow-2xl">
            @endif
        </div>

        <div class="md:w-1/2 p-10">
            <span class="text-blue-900 font-bold uppercase text-sm tracking-widest">{{ $modelo->fabricante->nome }}</span>
            <h1 class="text-4xl font-black text-slate-800 uppercase mb-4">{{ $modelo->nome }}</h1>

            <div class="grid grid-cols-2 gap-4 mb-8 text-sm uppercase">
                <div class="bg-slate-50 p-3 rounded"><strong>Calibre:</strong> {{ $modelo->calibre->nome }}</div>
                <div class="bg-slate-50 p-3 rounded"><strong>Capacidade:</strong> {{ $modelo->capacidade }}</div>
                <div class="bg-slate-50 p-3 rounded"><strong>Funcionamento:</strong> {{ $modelo->sistema_funcionamento }}</div>
                <div class="bg-slate-50 p-3 rounded"><strong>Cano:</strong> {{ $modelo->comprimento_cano }}</div>
            </div>

            <hr class="mb-8">

            <div class="space-y-4 mb-10">
                <div class="flex justify-between items-center bg-green-50 p-4 rounded-lg border border-green-100">
                    <span class="font-bold text-green-800 uppercase text-sm">Preço à Vista (5% taxa)</span>
                    <span class="text-3xl font-black text-green-700">R$ {{ number_format($modelo->valor_vista, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between items-center bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <span class="font-bold text-blue-800 uppercase text-sm">Parcelado (10% taxa)</span>
                    <div class="text-right">
                        <span class="text-2xl font-black text-blue-900">R$ {{ number_format($modelo->valor_parcelado, 2, ',', '.') }}</span>
                        <small class="block text-[10px] text-blue-400 font-bold uppercase">Consignado em Folha</small>
                    </div>
                </div>
            </div>

            <form action="{{ route('associado.comprar') }}" method="POST">
                @csrf
                <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-black py-5 rounded-xl shadow-lg transition uppercase tracking-widest">
                    Solicitar Aquisição Agora
                </button>
            </form>
        </div>
    </div>
</div>
@endsection