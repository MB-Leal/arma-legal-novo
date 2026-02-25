@extends('layouts.associado')

@section('content')
<div class="min-h-screen bg-slate-950 text-white selection:bg-blue-500/30" 
     style="background-image: linear-gradient(rgba(2, 6, 23, 0.94), rgba(2, 6, 23, 0.94)), url('{{ asset('imagens/banner-militar.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"
     x-data="{ 
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
     }">

    <div class="container mx-auto px-4 py-12">
        
        <div class="mb-10 flex items-center gap-6 bg-slate-900/60 p-8 rounded-[2.5rem] border border-white/5 backdrop-blur-xl shadow-2xl">
            <div class="bg-blue-600/20 p-4 rounded-2xl border border-blue-500/20">
                <i class="fa-solid fa-calculator text-3xl text-blue-500"></i>
            </div>
            <div>
                <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter italic">Simulador de <span class="text-blue-500">Aquisição</span></h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase mt-1 tracking-[0.2em]">Ajuste as parcelas para ver o impacto no seu investimento</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-slate-900/40 p-8 md:p-10 rounded-[2.5rem] border border-white/5 backdrop-blur-sm shadow-xl">
                    <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-8 flex items-center">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></span>
                        Configurações do Plano
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <label class="block text-[9px] font-black text-slate-500 uppercase mb-3 tracking-widest">Equipamento Selecionado</label>
                            <div class="p-6 bg-black/40 rounded-2xl border border-white/5 group transition-all">
                                <p class="text-lg font-black text-white uppercase tracking-tighter leading-tight">{{ $modelo->nome }}</p>
                                <div class="mt-4 flex items-center gap-4">
                                    <span class="text-[10px] font-black text-blue-500 uppercase bg-blue-500/10 px-2 py-1 rounded">Calibre: {{ $modelo->calibre }}</span>
                                    <span class="text-[10px] font-black text-slate-500 uppercase">{{ $modelo->fabricante }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-slate-500 uppercase mb-3 tracking-widest">Plano de Parcelamento (Consignado)</label>
                            <div class="relative">
                                <select x-model="parcelas" class="w-full p-5 bg-slate-900 border-2 border-slate-800 rounded-2xl focus:border-blue-600 outline-none font-black text-2xl text-white transition appearance-none cursor-pointer shadow-inner">
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}">{{ $i }}x Parcelas Mensais</option>
                                    @endfor
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-6 top-6 text-blue-500 pointer-events-none"></i>
                            </div>
                            <p class="text-[9px] text-slate-500 font-bold uppercase mt-4 leading-relaxed">
                                <i class="fa-solid fa-circle-info mr-1 text-blue-500/50"></i>
                                O desconto em folha está sujeito à margem consignável disponível no momento da averbação junto ao Estado.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-900/10 p-6 rounded-2xl border border-blue-500/20 flex items-start gap-5">
                    <i class="fa-solid fa-shield-halved text-blue-500 text-xl mt-1"></i>
                    <p class="text-[10px] text-slate-400 font-bold uppercase leading-relaxed">
                        Este simulador apresenta valores aproximados com base nas taxas atuais. O valor exato da parcela será confirmado no ato da assinatura do contrato físico e análise do convênio.
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-900 border border-white/10 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/10 rounded-full blur-[80px]"></div>

                    <h3 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-10 border-b border-white/5 pb-5">Resumo Financeiro</h3>

                    <div class="space-y-8">
                        <div>
                            <span class="block text-[10px] text-slate-500 font-black uppercase mb-2 tracking-widest">Valor de cada Parcela</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-xl font-bold text-blue-500">R$</span>
                                <span class="text-5xl font-black text-white tracking-tighter" x-text="valorParcela.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-white/5 space-y-4">
                            <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                                <span class="text-slate-500">Valor de Tabela:</span>
                                <span class="text-slate-200" x-text="'R$ ' + precoBase.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                                <span class="text-slate-500">Encargos Operacionais:</span>
                                <span class="text-blue-400" x-text="'R$ ' + (total - precoBase).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </div>
                            
                            <div class="flex justify-between items-end pt-6">
                                <span class="text-[11px] font-black uppercase text-blue-500 tracking-[0.2em]">Total Final</span>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-slate-400">R$</span>
                                    <span class="text-2xl font-black text-white tracking-tighter" x-text="total.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('associado.conferir') }}" method="POST" class="mt-12">
                        @csrf
                        <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
                        <input type="hidden" name="parcelas" :value="parcelas">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-blue-900/40 transition-all duration-300 uppercase tracking-[0.2em] text-xs flex items-center justify-center group border border-blue-400/30">
                            Confirmar Aquisição
                            <i class="fa-solid fa-chevron-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                        </button>
                    </form>
                </div>

                <a href="{{ route('associado.catalogo') }}" class="flex items-center justify-center p-4 text-slate-500 hover:text-white transition-colors text-[10px] font-black uppercase tracking-[0.3em] group">
                    <i class="fa-solid fa-arrow-left-long mr-3 group-hover:-translate-x-2 transition-transform"></i>
                    Retornar ao Catálogo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection