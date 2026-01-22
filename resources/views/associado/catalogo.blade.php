@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-10 bg-white p-6 rounded-lg shadow-sm border-l-8 border-blue-900">
        <div>
            <h2 class="text-xl font-bold text-slate-800 uppercase">Olá, {{ $nomeAssociado }}</h2>
            <p class="text-slate-600">Selecione o modelo desejado para iniciar o processo de aquisição.</p>
        </div>
        <img src="{{ asset('imagens/arma.ico') }}" alt="Ícone" class="h-12">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($modelos as $modelo)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
            <div class="h-56 bg-slate-200 relative">
                @if($modelo->imagens->where('principal', true)->first())
                <img src="{{ asset('storage/' . $modelo->imagens->where('principal', true)->first()->caminho) }}"
                    class="w-full h-full object-cover" alt="{{ $modelo->nome }}">
                @else
                {{-- Imagem padrão caso não haja foto --}}
                <div class="flex items-center justify-center h-full text-slate-400">
                    <span>Sem imagem disponível</span>
                </div>
                @endif
                <div class="absolute top-2 right-2 bg-blue-900 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">
                    {{ $modelo->calibre }}
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 uppercase mb-2">{{ $modelo->nome }}</h3>
                <p class="text-sm text-slate-500 mb-4 h-12 overflow-hidden">{{ $modelo->fabricante }} - {{ $modelo->sistema_funcionamento }}</p>

                <div class="flex items-end justify-between border-t pt-4">
                    <div>
                        <span class="block text-xs text-slate-400 uppercase font-semibold">Preço Estimado</span>
                        <span class="text-2xl font-black text-blue-900">R$ {{ number_format($modelo->preco, 2, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('associado.comprar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            TENHO INTERESSE
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection