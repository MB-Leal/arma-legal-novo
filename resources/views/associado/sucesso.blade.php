@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto text-center">

        <div class="mb-8 flex justify-center">
            <div class="bg-green-100 p-6 rounded-full">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-black text-slate-800 uppercase mb-4">Pedido Realizado com Sucesso!</h1>
        <p class="text-slate-600 mb-10">
            Olá, <strong>{{ session('associado_nome') }}</strong>. Sua intenção de compra para o modelo
            <span class="text-blue-900 font-bold uppercase">{{ $pedido->modelo->nome }}</span> foi registrada no sistema do FASPM.
        </p>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 mb-8">
            <h3 class="text-sm font-bold text-slate-400 uppercase mb-6 tracking-widest">Próximos Passos</h3>

            <div class="space-y-4">
                <a href="{{ route('associado.pdf', $pedido->id) }}" target="_blank"
                    class="w-full flex items-center justify-center bg-blue-900 hover:bg-blue-800 text-white font-black py-5 rounded-xl shadow-lg transition uppercase tracking-widest">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Descarregar Requerimento (PDF)
                </a>

                <p class="text-xs text-slate-500 italic">
                    * Imprima, assine e encaminhe o documento ao setor de armamento conforme as instruções do edital.
                </p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('associado.pedido') }}" class="text-blue-900 font-bold uppercase text-xs hover:underline">
                Ver Meus Pedidos
            </a>
            <span class="hidden sm:inline text-slate-300">|</span>
            <a href="{{ route('associado.catalogo') }}" class="text-blue-900 font-bold uppercase text-xs hover:underline">
                Voltar ao Catálogo
            </a>
        </div>
    </div>
</div>
@endsection