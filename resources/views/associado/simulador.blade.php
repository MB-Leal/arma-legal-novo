@extends('layouts.associado')

@section('content')
<div x-data="{ 
    precoBase: {{ $modelo->preco }},
    taxasMap: {{ $taxas->toJson() }},
    parcelas: 12,
    get percentual() {
        return parseFloat(this.taxasMap[this.parcelas] || 0);
    },
    get total() { 
        return this.precoBase * (1 + this.percentual);
    },
    get valorParcela() { return this.total / this.parcelas }
}" class="py-12">

    <div class="max-w-5xl mx-auto px-4">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter flex items-center">
                <i class="fa-solid fa-calculator mr-4 text-blue-900"></i>
                Simulador de Financiamento
            </h2>
            <p class="text-slate-500 font-bold uppercase text-xs mt-2">Ajuste as parcelas para ver o valor final do seu investimento</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                        <span class="w-2 h-2 bg-blue-900 rounded-full mr-2"></span>
                        Detalhes da Aquisição
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Modelo Selecionado</label>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 font-black text-blue-900 uppercase text-sm">
                                {{ $modelo->nome }}
                            </div>
                            <div class="mt-3 flex items-center text-[10px] text-slate-400 font-bold uppercase">
                                <i class="fa-solid fa-tag mr-2"></i>
                                Calibre: {{ $modelo->calibre }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Plano de Parcelas</label>
                            <select x-model="parcelas" class="w-full p-4 bg-white border-2 border-slate-100 rounded-2xl focus:border-blue-900 outline-none font-black text-xl text-slate-800 transition shadow-inner">
                                @for ($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i }}">{{ $i }}x Parcelas Fixas</option>
                                @endfor
                            </select>
                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-3 leading-tight">
                                * O desconto em folha está sujeito à margem consignável disponível no momento da averbação.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 flex items-start">
                    <i class="fa-solid fa-shield-halved text-blue-300 mt-1 mr-4"></i>
                    <p class="text-[10px] text-blue-900/60 font-bold uppercase leading-relaxed">
                        Este simulador apresenta valores aproximados. O valor exato da parcela será confirmado após o envio do requerimento e análise do convênio com a Amazon Serviços de Armaria.
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-3xl"></div>

                    <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-8 border-b border-white/10 pb-4">Resumo do Pedido</h3>

                    <div class="space-y-6">
                        <div>
                            <span class="block text-[10px] text-slate-400 font-black uppercase mb-1">Valor da Parcela</span>
                            <div class="text-4xl font-black text-white tracking-tighter">
                                R$ <span x-text="valorParcela.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-white/10 space-y-3">
                            <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <span>Preço de Tabela:</span>
                                <span class="text-white" x-text="'R$ ' + precoBase.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </div>
                            <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <span>Acréscimo Parcelamento:</span>
                                <span class="text-white" x-text="'R$ ' + (total - precoBase).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </div>
                            <div class="flex justify-between pt-4 text-sm font-black uppercase">
                                <span class="text-blue-400 tracking-widest">Total Geral:</span>
                                <span class="text-xl" x-text="'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('associado.comprar') }}" method="POST" class="mt-10">
                        @csrf
                        <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
                        <input type="hidden" name="parcelas" :value="parcelas">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-2xl shadow-xl transition-all duration-300 uppercase tracking-widest text-xs flex items-center justify-center group">
                            Confirmar Aquisição
                            <i class="fa-solid fa-chevron-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>

                <a href="{{ route('associado.catalogo') }}" class="flex items-center justify-center p-4 text-slate-400 hover:text-slate-800 transition text-[10px] font-black uppercase tracking-widest">
                    <i class="fa-solid fa-arrow-left-long mr-2"></i>
                    Voltar ao Catálogo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection