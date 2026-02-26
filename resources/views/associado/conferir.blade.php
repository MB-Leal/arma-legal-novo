@extends('layouts.associado')

@section('content')
<div class="min-h-screen bg-slate-950 text-white py-10" style="background-image: linear-gradient(rgba(2, 6, 23, 0.96), rgba(2, 6, 23, 0.96)), url('{{ asset('imagens/banner-militar.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <div class="max-w-5xl mx-auto px-4">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter">Conferência de <span class="text-blue-500">Dados</span></h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Verifique as informações antes de gerar o documento</p>
            </div>
            <img src="{{ asset('imagens/logo_faspm.png') }}" class="h-16 opacity-50">
        </div>

        <form action="{{ route('associado.processar') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
            <input type="hidden" name="parcelas" value="{{ $parcelas }}">
            <input type="hidden" name="valor_total" value="{{ $valor_total }}">

            <div class="bg-blue-600/10 border border-blue-500/20 p-6 rounded-3xl flex flex-col md:flex-row justify-between items-center gap-6 backdrop-blur-sm">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-600 p-3 rounded-2xl shadow-lg">
                        <i class="fa-solid fa-gun text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Equipamento</p>
                        <p class="text-lg font-black uppercase">{{ $modelo->nome }}</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total em {{ $parcelas }}x</p>
                    <p class="text-3xl font-black text-white italic">R$ {{ number_format($valor_total, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-slate-900/80 border border-white/5 p-8 rounded-[2.5rem] backdrop-blur-md shadow-2xl">
                <h3 class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center">
                    <i class="fa-solid fa-user-shield mr-2"></i> Informações do Solicitante
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase mb-2 block">Nome Completo</label>
                        <input type="text" value="{{ $associado->nome_completo }}" readonly class="w-full bg-slate-950/50 border border-white/10 p-4 rounded-xl text-slate-400 font-bold uppercase text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-500 uppercase mb-2 block">CPF / Matrícula</label>
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
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Situação (Status)</label>
                        <select name="status" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:border-blue-500 outline-none">
                            <option value="ativo" {{ $associado->status == 'ativo' ? 'selected' : '' }}>ATIVO</option>
                            <option value="reserva" {{ $associado->status == 'reserva' ? 'selected' : '' }}>RESERVA</option>
                            <option value="inativo" {{ $associado->status == 'inativo' ? 'selected' : '' }}>INATIVO</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">OPM / Unidade</label>
                        <input type="text" name="opm" value="{{ $associado->opm }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">E-mail</label>
                        <input type="email" name="email" value="{{ $associado->email }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Celular</label>
                        <input type="text" name="celular" value="{{ $associado->celular }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:border-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/80 border border-white/5 p-8 rounded-[2.5rem] backdrop-blur-md shadow-2xl">
                <h3 class="text-blue-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 flex items-center">
                    <i class="fa-solid fa-map-location-dot mr-2"></i> Endereço Residencial
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">CEP</label>
                        <input type="text" name="cep" id="cep" value="{{ $associado->endereco->cep }}" required maxlength="9" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Logradouro</label>
                        <input type="text" name="logradouro" id="logradouro" value="{{ $associado->endereco->logradouro }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Número</label>
                        <input type="text" name="numero" value="{{ $associado->endereco->numero }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none">
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Bairro</label>
                        <input type="text" name="bairro" id="bairro" value="{{ $associado->endereco->bairro }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ $associado->endereco->cidade }}" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Estado (UF)</label>
                        <input type="text" name="estado" id="estado" value="{{ $associado->endereco->estado }}" maxlength="2" required class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-400 uppercase mb-2 block">Complemento</label>
                        <input type="text" name="complemento" value="{{ $associado->endereco->complemento }}" class="w-full bg-slate-900 border border-slate-700 p-4 rounded-xl text-white font-bold text-sm uppercase outline-none" placeholder="Opcional">
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6 items-center justify-between pt-6">
                <p class="text-[10px] text-slate-500 font-bold uppercase max-w-md italic">
                    <i class="fa-solid fa-triangle-exclamation text-blue-500 mr-1"></i>
                    Confira se o endereço está correto para evitar atrasos na emissão do documento.
                </p>
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 text-white px-16 py-6 rounded-2xl font-black uppercase tracking-widest text-xs shadow-2xl transition-all flex items-center gap-3 group">
                    Gerar Requerimento Oficial
                    <i class="fa-solid fa-file-pdf group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('cep').addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');
        
        if (cep.length === 8) {
            // Feedback visual opcional
            this.classList.add('opacity-50');

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    this.classList.remove('opacity-50');
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro.toUpperCase();
                        document.getElementById('bairro').value = data.bairro.toUpperCase();
                        document.getElementById('cidade').value = data.localidade.toUpperCase();
                        document.getElementById('estado').value = data.uf.toUpperCase();
                        
                        // Foca no campo número após preencher o endereço
                        document.getElementsByName('numero')[0].focus();
                    } else {
                        alert('CEP não encontrado.');
                    }
                })
                .catch(error => {
                    this.classList.remove('opacity-50');
                    console.error('Erro ao buscar CEP:', error);
                });
        }
    });

    // Máscara básica para o CEP (00000-000)
    document.getElementById('cep').addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,5})(\d{0,3})/);
        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2];
    });
</script>
@endsection