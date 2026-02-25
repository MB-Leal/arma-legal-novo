@extends('layouts.associado')

@section('content')
<div class="min-h-screen bg-slate-950 text-white py-10" style="background-image: linear-gradient(rgba(2, 6, 23, 0.96), rgba(2, 6, 23, 0.96)), url('{{ asset('imagens/banner-militar.jpg') }}'); background-size: cover; background-attachment: fixed;">
    
    <div class="max-w-5xl mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter">Conferência de <span class="text-blue-500">Dados</span></h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Complete as informações para gerar o requerimento oficial</p>
            </div>
            <img src="{{ asset('imagens/logo_faspm.png') }}" class="h-16 opacity-50">
        </div>

        <form action="{{ route('associado.processar') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
            <input type="hidden" name="parcelas" value="{{ $parcelas }}">
            <input type="hidden" name="valor_total" value="{{ $valor_total }}">

            <div class="bg-blue-600/10 border border-blue-500/20 p-6 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-600 p-3 rounded-2xl shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-gun text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Equipamento Selecionado</p>
                        <p class="text-lg font-black uppercase">{{ $modelo->nome }}</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total em {{ $parcelas }}x</p>
                    <p class="text-3xl font-black text-white italic">R$ {{ number_format($valor_total, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-slate-900/80 border border-white/5 p-8 rounded-[2.5rem] backdrop-blur-md">
                <h3 class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center">
                    <i class="fa-solid fa-user-shield mr-2"></i> Informações do Solicitante
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase mb-2 block">Nome Completo (Bloqueado)</label>
                        <input type="text" value="{{ $associado->nome_completo }}" readonly class="w-full bg-slate-950/50 border border-white/10 p-4 rounded-xl text-slate-400 font-bold uppercase text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-500 uppercase mb-2 block">CPF / MF (Bloqueado)</label>
                        <input type="text" value="{{ $associado->cpf }} / {{ $associado->matricula }}" readonly class="w-full bg-slate-950/50 border border-white/10 p-4 rounded-xl text-slate-400 font-bold text-sm cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">RG Militar</label>
                        <input type="text" name="rg_militar" value="{{ $associado->rg_militar }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:border-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Posto / Graduação</label>
                        <select name="posto_graduacao" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:border-blue-500 outline-none">
                            @foreach(['AL CFP PM/BM', 'SD PM/BM', 'CB PM/BM', '3º SGT PM/BM', '2º SGT PM/BM', '1º SGT PM/BM', 'SUB TEN PM/BM', 'CAD PM/BM', 'ASP PM/BM', '2º TEN PM/BM', '1º TEN PM/BM', 'CAP PM/BM', 'MAJ PM/BM', 'TEN CEL PM/BM', 'CEL PM/BM'] as $posto)
                                <option value="{{ $posto }}" {{ $associado->posto_graduacao == $posto ? 'selected' : '' }}>{{ $posto }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">OPM / Unidade</label>
                        <input type="text" name="opm" value="{{ $associado->opm }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase focus:border-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/80 border border-white/5 p-8 rounded-[2.5rem] backdrop-blur-md">
                <h3 class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center">
                    <i class="fa-solid fa-map-location-dot mr-2"></i> Endereço para Requerimento
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-1">
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">CEP</label>
                        <input type="text" name="cep" value="{{ $associado->endereco->cep }}" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Logradouro</label>
                        <input type="text" name="logradouro" value="{{ $associado->endereco->logradouro }}" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Número</label>
                        <input type="text" name="numero" value="{{ $associado->endereco->numero }}" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm">
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6 items-center justify-between pt-6">
                <p class="text-[10px] text-slate-500 font-bold uppercase max-w-md">
                    Ao clicar em avançar, você confirma que todos os dados acima são verdadeiros e autoriza o FASPM a processar sua intenção de compra.
                </p>
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 text-white px-16 py-6 rounded-2xl font-black uppercase tracking-widest text-xs shadow-2xl shadow-blue-600/20 transition-all flex items-center gap-3">
                    Gerar Requerimento Oficial
                    <i class="fa-solid fa-file-pdf"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection