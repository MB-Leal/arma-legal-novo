@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 pb-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Editar Associado</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Atualize as informações de {{ $associado->nome_completo }}</p>
        </div>
        <a href="{{ route('associados.index') }}" class="text-slate-400 hover:text-slate-600 text-xs font-black uppercase transition">
            &larr; Voltar
        </a>
    </div>

    <form action="{{ route('associados.update', $associado->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-blue-900 text-xs font-black uppercase flex items-center">
                    <i class="fa-solid fa-user-pen mr-2"></i> Informações do Militar
                </h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nome Completo</label>
                    <input type="text" name="nome_completo" value="{{ old('nome_completo', $associado->nome_completo) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf', $associado->cpf) }}" maxlength="11" required class="w-full p-3 bg-slate-100 border-2 border-slate-200 rounded-xl outline-none font-bold text-sm text-slate-500 cursor-not-allowed" readonly>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">RG Militar</label>
                    <input type="number" name="rg_militar" value="{{ old('rg_militar', $associado->rg_militar) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Matrícula</label>
                    <input type="text" name="matricula" value="{{ old('matricula', $associado->matricula) }}" required class="w-full p-3 bg-slate-100 border-2 border-slate-200 rounded-xl outline-none font-bold text-sm text-slate-500 cursor-not-allowed" readonly>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Situação</label>
                    <select name="status" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                        <option value="ativo" {{ $associado->status == 'ativo' ? 'selected' : '' }}>ATIVO</option>
                        <option value="reserva" {{ $associado->status == 'reserva' ? 'selected' : '' }}>VETERANO</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Posto / Graduação</label>
                    <select name="posto_graduacao" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                        @foreach(['AL CFP PM/BM', 'SD PM/BM', 'CB PM/BM', '3º SGT PM/BM', '2º SGT PM/BM', '1º SGT PM/BM', 'SUB TEN PM/BM', 'CAD PM/BM', 'ASP PM/BM', '2º TEN PM/BM', '1º TEN PM/BM', 'CAP PM/BM', 'MAJ PM/BM', 'TEN CEL PM/BM', 'CEL PM/BM'] as $posto)
                            <option value="{{ $posto }}" {{ $associado->posto_graduacao == $posto ? 'selected' : '' }}>{{ $posto }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">OPM (Sigla)</label>
                    <input type="text" name="opm" value="{{ old('opm', $associado->opm) }}" maxlength="10" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $associado->email) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Celular / WhatsApp</label>
                    <input type="text" name="celular" value="{{ old('celular', $associado->celular) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-blue-900 text-xs font-black uppercase flex items-center">
                    <i class="fa-solid fa-house-chimney-window mr-2"></i> Endereço Atualizado
                </h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">CEP</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep', $associado->endereco->cep ?? '') }}" maxlength="8" required
                           class="w-full p-3 bg-blue-50 border-2 border-blue-100 rounded-xl focus:border-blue-900 outline-none font-black text-blue-900 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Logradouro / Rua</label>
                    <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro', $associado->endereco->logradouro ?? '') }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Número</label>
                    <input type="text" name="numero" value="{{ old('numero', $associado->endereco->numero ?? '') }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Bairro</label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $associado->endereco->bairro ?? '') }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Município / Cidade</label>
                    <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $associado->endereco->cidade ?? '') }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Estado (UF)</label>
                    <input type="text" name="estado" id="estado" value="{{ old('estado', $associado->endereco->estado ?? '') }}" maxlength="2" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Complemento</label>
                    <input type="text" name="complemento" value="{{ old('complemento', $associado->endereco->complemento ?? '') }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-black py-4 px-12 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs">
                Atualizar Cadastro
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('cep').addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');
        if (cep !== "") {
            let validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(dados => {
                        if (!("erro" in dados)) {
                            document.getElementById('logradouro').value = dados.logradouro.toUpperCase();
                            document.getElementById('bairro').value = dados.bairro.toUpperCase();
                            document.getElementById('cidade').value = dados.localidade.toUpperCase();
                            document.getElementById('estado').value = dados.uf.toUpperCase();
                        }
                    });
            }
        }
    });
</script>
@endsection