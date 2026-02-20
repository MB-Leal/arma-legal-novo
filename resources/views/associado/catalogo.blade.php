@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ openModal: false, arma: {} }">

    <div class="mb-10 flex flex-col md:flex-row justify-between items-end border-b border-slate-200 pb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Armas Disponíveis</h1>
            <p class="text-slate-500 font-bold uppercase text-xs">Olá, {{ $nomeAssociado }}. Confira os modelos autorizados para aquisição.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                Programa Arma Legal
            </span>
        </div>
    </div>
    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-start p-4 bg-slate-100/50 border-l-2 border-slate-300 rounded-r-xl">
            <i class="fa-solid fa-circle-info text-slate-400 mt-0.5 mr-3 text-sm"></i>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-wider">Disponibilidade de Estoque</p>
                <p class="text-[10px] text-slate-400 font-medium leading-relaxed">
                    As imagens são ilustrativas. A conclusão do pedido depende da confirmação de disponibilidade pelo fabricante e autorização do comando.
                </p>
            </div>
        </div>

        <div class="flex items-start p-4 bg-blue-50/50 border-l-2 border-blue-200 rounded-r-xl">
            <i class="fa-solid fa-scale-balanced text-blue-300 mt-0.5 mr-3 text-sm"></i>
            <div>
                <p class="text-[10px] font-black text-blue-900/50 uppercase tracking-wider">Regulamentação Legal</p>
                <p class="text-[10px] text-slate-400 font-medium leading-relaxed">
                    A aquisição de arma de fogo é restrita a militares ativos/reservas conforme legislação vigente e normas internas do FASPM.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($modelos as $modelo)
        @php
        // Preço calculado para 1 parcela (0.90% de taxa)
        $preco1x = $modelo->preco * 1.0090;
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">

            <div class="relative h-48 bg-slate-100 p-4 flex items-center justify-center group">
                @if($modelo->imagens->where('principal', true)->first())
                <img src="{{ asset('storage/' . $modelo->imagens->where('principal', true)->first()->caminho) }}"
                    class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-110"
                    alt="{{ $modelo->nome }}">
                @else
                <i class="fa-solid fa-gun text-4xl text-slate-300"></i>
                @endif

                @if($modelo->codigo)
                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-[9px] font-black text-slate-500 uppercase border border-slate-200">
                    Cód: {{ $modelo->codigo }}
                </span>
                @endif
            </div>

            <div class="p-5 flex-grow flex flex-col">
                <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest mb-1">{{ $modelo->fabricante }}</span>
                <h3 class="text-base font-black text-slate-800 uppercase leading-tight mb-2 h-10 overflow-hidden">
                    {{ $modelo->nome }}
                </h3>

                <div class="flex items-center gap-4 mb-4">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Calibre</span>
                        <span class="text-xs font-black text-slate-700">{{ $modelo->calibre }}</span>
                    </div>
                    <div class="h-6 w-px bg-slate-200"></div>
                    <div class="flex flex-col">
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Capacidade</span>
                        <span class="text-xs font-black text-slate-700">{{ $modelo->capacidade_tiro }}</span>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">A partir de</span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs font-black text-slate-800 uppercase">R$</span>
                        <span class="text-2xl font-black text-blue-900 tracking-tighter">
                            {{ number_format($preco1x, 2, ',', '.') }}
                        </span>
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Valor à vista</p>
                </div>

                <button @click="arma = {{ $modelo->toJson() }}; openModal = true"
                    class="w-full mt-4 bg-slate-900 hover:bg-black text-white text-[10px] font-black uppercase py-3 rounded-xl transition tracking-widest">
                    Ver Detalhes Técnicos
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div x-show="openModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/95 backdrop-blur-sm"
        x-transition.opacity
        x-cloak>

        <div class="bg-white w-full max-w-6xl rounded-3xl shadow-2xl overflow-hidden relative flex flex-col md:flex-row max-h-[95vh]" @click.away="openModal = false">

            <button @click="openModal = false" class="absolute top-5 right-5 z-50 text-slate-400 hover:text-slate-800 transition">
                <i class="fa-solid fa-circle-xmark text-3xl"></i>
            </button>

            <div class="md:w-5/12 bg-slate-50 p-6 flex flex-col border-r border-slate-100" x-data="{ activeImg: 0 }">
                <div class="flex-grow flex items-center justify-center min-h-[300px]">
                    <template x-for="(img, index) in arma.imagens" :key="index">
                        <img x-show="activeImg === index"
                            :src="'/storage/' + img.caminho"
                            class="max-h-full max-w-full object-contain drop-shadow-2xl"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95">
                    </template>
                </div>

                <div class="flex justify-center gap-3 mt-6">
                    <template x-for="(img, index) in arma.imagens" :key="index">
                        <button @click="activeImg = index"
                            :class="activeImg === index ? 'border-blue-900 ring-2 ring-blue-100' : 'border-slate-200 opacity-60 hover:opacity-100'"
                            class="w-20 h-20 bg-white border-2 rounded-xl p-1 transition overflow-hidden">
                            <img :src="'/storage/' + img.caminho" class="w-full h-full object-contain">
                        </button>
                    </template>
                </div>
            </div>

            <div class="md:w-7/12 p-8 md:p-10 overflow-y-auto bg-white">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-blue-900 text-white text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-widest" x-text="arma.tipo"></span>
                        <span class="text-xs font-black text-blue-700 uppercase tracking-widest" x-text="arma.fabricante"></span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none" x-text="arma.nome"></h2>
                    <p class="text-slate-400 text-[10px] font-bold mt-2 uppercase">Código de Referência: <span class="text-slate-600" x-text="arma.codigo || 'N/A'"></span></p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-6 gap-x-4 border-t border-b border-slate-100 py-8 mb-8">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Calibre</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.calibre"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Capacidade</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.capacidade_tiro"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Acabamento</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.acabamento"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Funcionamento</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.sistema_funcionamento"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Comprimento Cano</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.comprimento_cano"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">País de Origem</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.pais_fabricacao"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Alma do Cano</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.tipo_alma"></p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Raias / Sentido</p>
                        <p class="text-xs font-black text-slate-800 uppercase">
                            <span x-text="arma.qtd_raias"></span> Raias (<span x-text="arma.sentido_raias"></span>)
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Unidades em Canos</p>
                        <p class="text-xs font-black text-slate-800 uppercase" x-text="arma.qtd_cano"></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-6 mb-8">
                    <div class="flex-1">
                        <template x-if="arma.observacao">
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase mb-2">Informações Adicionais</h4>
                                <p class="text-xs text-slate-500 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100 italic" x-text="arma.observacao"></p>
                            </div>
                        </template>
                    </div>
                    <div class="sm:w-1/3 bg-blue-50 p-4 rounded-2xl border border-blue-100 flex flex-col justify-center text-center">
                        <p class="text-[9px] font-black text-blue-400 uppercase mb-1">Disponíveis</p>
                        <p class="text-2xl font-black text-blue-900" x-text="arma.quantidade"></p>
                        <p class="text-[8px] font-bold text-blue-300 uppercase">Estoque FASPM</p>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Investimento à vista</span>
                        <div class="flex items-baseline gap-1 text-white">
                            <span class="text-sm font-bold">R$</span>
                            <span class="text-3xl font-black tracking-tighter" x-text="(arma.preco * 1.0090).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                        </div>
                        <p class="text-[8px] text-slate-500 font-bold uppercase mt-1">Valor Final</p>
                    </div>
                    <a :href="'/simulador/' + arma.id"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition shadow-xl shadow-blue-600/20 text-center">
                        Ir para o Simulador
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection