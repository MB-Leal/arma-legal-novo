@extends('layouts.associado')

@section('content')
<div class="min-h-screen bg-slate-950 text-white selection:bg-blue-500/30" 
     style="background-image: linear-gradient(rgba(2, 6, 23, 0.94), rgba(2, 6, 23, 0.94)), url('{{ asset('imagens/banner-militar.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"
     x-data="{ 
        openModal: false, 
        arma: {}, 
        filtroFabricante: '' 
     }">

    <div class="container mx-auto px-4 py-10">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6 bg-slate-900/60 p-8 rounded-3xl border border-white/5 backdrop-blur-xl shadow-2xl">
            <div class="flex items-center gap-6">
                <img src="{{ asset('imagens/fas.png') }}" class="h-16 md:h-20 drop-shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                <div>
                    <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tighter italic">Arma <span class="text-blue-500">Legal</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-xs font-bold uppercase mt-1 tracking-[0.2em]">Programa de Aquisição de armamento para contribuintes FASPM</p>
                </div>
            </div>

            <div class="w-full md:w-72 bg-slate-950/50 p-4 rounded-2xl border border-white/5">
                <label class="block text-[9px] font-black text-blue-400 uppercase mb-2 tracking-widest">Filtrar por Marca</label>
                <div class="relative">
                    <select x-model="filtroFabricante" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-xs font-black uppercase outline-none focus:border-blue-600 transition appearance-none cursor-pointer text-white">
                        <option value="">Todas as Marcas</option>
                        @foreach($modelos->pluck('fabricante')->unique() as $fab)
                            <option value="{{ $fab }}">{{ $fab }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-blue-500 pointer-events-none text-xs"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($modelos as $modelo)
            <div x-show="filtroFabricante === '' || filtroFabricante === '{{ $modelo->fabricante }}'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 class="bg-slate-900/40 border border-white/5 rounded-[2.5rem] overflow-hidden group hover:border-blue-500/50 hover:bg-slate-900/80 transition-all duration-500 flex flex-col">
                
                <div class="h-52 p-8 flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-radial-gradient from-blue-500/5 to-transparent opacity-50"></div>
                    @if($modelo->imagens->where('principal', true)->first())
                        <img src="{{ asset('storage/' . $modelo->imagens->where('principal', true)->first()->caminho) }}" 
                             class="relative z-10 max-h-full max-w-full object-contain transition-transform duration-700 group-hover:scale-110 drop-shadow-[0_10px_30px_rgba(0,0,0,0.6)]">
                    @else
                        <i class="fa-solid fa-gun text-5xl text-slate-800"></i>
                    @endif
                </div>

                <div class="p-6 pt-0 flex flex-col flex-grow">
                    <div class="text-center mb-4">
                        <span class="text-[9px] font-black text-blue-500 uppercase tracking-[0.2em] block mb-1">{{ $modelo->fabricante }}</span>
                        <h3 class="text-md font-black uppercase tracking-tighter text-slate-100 line-clamp-2 leading-tight">
                            {{ $modelo->nome }}
                        </h3>
                    </div>

                    <div class="mt-auto space-y-3">
                        <div class="flex justify-between items-center bg-white/5 rounded-xl px-4 py-2">
                            <span class="text-[9px] font-bold text-slate-500 uppercase">Preço à vista</span>
                            {{-- AJUSTE: Aplicado taxa de 0.9% sobre o preço de custo --}}
                            <span class="text-lg font-black text-white tracking-tighter">R$ {{ number_format($modelo->preco * 1.009, 2, ',', '.') }}</span>
                        </div>
                        @if($modelo->quantidade <= 2)
        <div class="bg-amber-500/10 border border-amber-500/20 rounded-lg p-2 flex items-center justify-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">
                Restam apenas {{ $modelo->quantidade }} {{ $modelo->quantidade > 1 ? 'unidades' : 'unidade' }}!
            </p>
        </div>
    @else
        <div class="text-[9px] font-bold text-slate-500 uppercase text-right italic">
            Disponível em estoque
        </div>
    @endif

                        <button @click="arma = {{ $modelo->toJson() }}; openModal = true" 
                                class="w-full bg-blue-700 hover:bg-blue-600 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus-circle text-xs"></i> Detalhes Técnicos
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div x-show="openModal" 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/98 backdrop-blur-md"
             x-transition.opacity x-cloak style="display: none;">
            
            <div class="bg-slate-900 w-full max-w-5xl rounded-[2.5rem] shadow-2xl border border-white/10 overflow-hidden relative flex flex-col md:flex-row max-h-[90vh] md:h-auto" @click.away="openModal = false">
                
                <button @click="openModal = false" class="absolute top-6 right-6 z-50 text-slate-500 hover:text-white transition-colors bg-black/20 p-2 rounded-full">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>

                <div class="md:w-1/2 bg-black/40 p-8 flex flex-col border-r border-white/5" x-data="{ activeImg: 0 }">
                    <div class="flex-grow flex items-center justify-center relative min-h-[250px] md:min-h-[400px]">
                        <template x-for="(img, index) in arma.imagens" :key="index">
                            <img x-show="activeImg === index" :src="'/storage/' + img.caminho" 
                                 class="relative z-10 max-h-full max-w-full object-contain drop-shadow-[0_20px_60px_rgba(0,0,0,0.9)]">
                        </template>
                    </div>
                    
                    <div class="flex justify-center gap-3 mt-6">
                        <template x-for="(img, index) in arma.imagens" :key="index">
                            <button @click="activeImg = index" 
                                    :class="activeImg === index ? 'border-blue-600 scale-105' : 'border-white/10 opacity-30'"
                                    class="w-16 h-16 bg-slate-800 border-2 rounded-xl p-1.5 transition-all">
                                <img :src="'/storage/' + img.caminho" class="w-full h-full object-contain">
                            </button>
                        </template>
                    </div>
                </div>

                <div class="md:w-1/2 p-8 md:p-12 overflow-y-auto custom-scrollbar flex flex-col">
                    <div class="mb-8">
                        <span class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-2 block" x-text="arma.fabricante"></span>
                        <h2 class="text-3xl font-black text-white uppercase tracking-tighter leading-tight" x-text="arma.nome"></h2>
                        <div class="mt-4 inline-flex items-center gap-2 bg-white/5 border border-white/5 px-3 py-1 rounded-full">
                            <span class="text-[9px] font-black text-slate-500 uppercase">Tipo:</span>
                            <span class="text-[9px] font-black text-white uppercase" x-text="arma.tipo"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-8 gap-y-6 mb-10 border-y border-white/5 py-8">
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Calibre</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.calibre"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Capacidade</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.capacidade_tiro"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Acabamento</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.acabamento"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Comprimento Cano</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.comprimento_cano"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Raias</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.qtd_raias + ' (' + arma.sentido_raias + ')'"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Qtd Cano</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.qtd_cano"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Sistema de Funcionamento</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.sistema_funcionamento"></span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">País</span>
                            <span class="text-sm font-black text-white uppercase" x-text="arma.pais_fabricacao"></span>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-white/5 flex flex-col gap-6">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Valor do Equipamento</span>
                            <div class="text-right">
                                <span class="text-xs font-bold text-slate-400">R$</span>
                                {{-- AJUSTE: Aplicado taxa de 0.9% no cálculo em tempo real do modal --}}
                                <span class="text-4xl font-black text-white tracking-tighter" x-text="(parseFloat(arma.preco) * 1.009).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                            </div>
                        </div>
                        <a :href="'/simulador/' + arma.id" 
                           class="w-full bg-blue-600 hover:bg-blue-500 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] transition-all shadow-xl shadow-blue-900/30 text-center block">
                            Iniciar Aquisição
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(59,130,246,0.3); }
</style>
@endsection