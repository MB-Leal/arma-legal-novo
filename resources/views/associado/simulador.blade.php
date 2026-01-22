@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ 
    precoBase: {{ $modelo->preco }},
    taxaParcelado: 0.10,
    parcelas: 12,
    get total() { return this.precoBase * (1 + this.taxaParcelado) },
    get valorParcela() { return this.total / this.parcelas }
}">

    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-black text-blue-900 uppercase mb-8 flex items-center">
            <img src="{{ asset('imagens/arma.ico') }}" class="h-8 mr-3">
            Simulador de Aquisição
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-200">
                <h3 class="font-bold text-slate-700 uppercase mb-6 border-b pb-2 text-sm tracking-widest">Configurações da Compra</h3>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Arma Selecionada</label>
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 font-bold text-blue-900 uppercase">
                        {{ $modelo->nome }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Quantidade de Parcelas (Consignado)</label>
                    <select x-model="parcelas" class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-blue-900 outline-none font-bold text-lg">
                        @for ($i = 1; $i <= 36; $i++)
                            <option value="{{ $i }}">{{ $i }}x vezes</option>
                            @endfor
                    </select>
                    <small class="text-[10px] text-slate-400 font-bold uppercase mt-2 block">
                        * Limite de parcelas sujeito à margem consignável.
                    </small>
                </div>
            </div>

            <div class="bg-blue-900 text-white p-8 rounded-2xl shadow-2xl flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-blue-300 uppercase mb-6 border-b border-blue-800 pb-2 text-sm tracking-widest">Resumo do Investimento</h3>

                    <div class="mb-8">
                        <span class="block text-xs text-blue-300 font-bold uppercase">Valor da Parcela</span>
                        <div class="text-5xl font-black">
                            R$ <span x-text="valorParcela.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                        </div>
                    </div>

                    <div class="space-y-3 opacity-80 text-sm font-semibold uppercase">
                        <div class="flex justify-between">
                            <span>Valor da Arma (Fábrica):</span>
                            <span x-text="'R$ ' + precoBase.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxa Administrativa (10%):</span>
                            <span x-text="'R$ ' + (precoBase * taxaParcelado).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                        </div>
                        <div class="flex justify-between border-t border-blue-800 pt-3 text-lg font-black">
                            <span>Total a Prazo:</span>
                            <span x-text="'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('associado.comprar') }}" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
                    <input type="hidden" name="parcelas" :value="parcelas">
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-400 text-blue-900 font-black py-4 rounded-xl shadow-lg transition uppercase tracking-widest">
                        Confirmar e Gerar Requerimento
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('associado.catalogo') }}" class="text-slate-400 hover:text-blue-900 font-bold uppercase text-xs flex items-center transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar ao Catálogo
            </a>
        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection