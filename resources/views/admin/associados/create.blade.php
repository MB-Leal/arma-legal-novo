@extends('layouts.admin')

@section('content')
@if ($errors->any())
<div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-r-xl shadow-sm">
    <h4 class="text-red-800 font-black uppercase text-xs mb-2">Atenção! Verifique os erros abaixo:</h4>
    <ul class="list-disc list-inside text-red-700 text-[10px] font-bold uppercase">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="max-w-5xl mx-auto px-4 pb-12">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Novo Associado</h1>
        <p class="text-slate-500 text-xs font-bold uppercase">Cadastre as informações militares e residenciais para o programa</p>
    </div>

    <form action="{{ route('associados.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-blue-900 text-xs font-black uppercase flex items-center">
                    <i class="fa-solid fa-id-card mr-2"></i> Informações do Militar
                </h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nome Completo</label>
                    <input type="text" name="nome_completo" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">CPF (Apenas números)</label>
                    <input type="text" name="cpf" maxlength="11" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">RG Militar</label>
                    <input type="number" name="rg_militar" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Matrícula</label>
                    <input type="text" name="matricula" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Situação</label>
                    <select name="status"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                        <option value="ativo">ATIVO</option>
                        <option value="reserva">VETERANO</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Posto / Graduação</label>
                    <select name="posto_graduacao" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                        <option value="">SELECIONE...</option>
                        @foreach(['AL CFP PM/BM', 'SD PM/BM', 'CB PM/BM', '3º SGT PM/BM', '2º SGT PM/BM', '1º SGT PM/BM', 'SUB TEN PM/BM', 'CAD PM/BM', 'ASP PM/BM', '2º TEN PM/BM', '1º TEN PM/BM', 'CAP PM/BM', 'MAJ PM/BM', 'TEN CEL PM/BM', 'CEL PM/BM'] as $posto)
                            <option value="{{ $posto }}">{{ $posto }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">OPM (Sigla)</label>
                    <input type="text" name="opm" maxlength="10" placeholder="Ex: QCG" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">E-mail</label>
                    <input type="email" name="email"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Celular / WhatsApp</label>
                    <input type="text" name="celular"  placeholder="(91) 9...." class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-blue-900 text-xs font-black uppercase flex items-center">
                    <i class="fa-solid fa-map-location-dot mr-2"></i> Endereço Residencial
                </h3>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">CEP</label>
                    <input type="text" name="cep" id="cep" maxlength="8"  placeholder="00000000"
                           class="w-full p-3 bg-blue-50 border-2 border-blue-100 rounded-xl focus:border-blue-900 outline-none font-black text-blue-900 text-sm transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Logradouro / Rua</label>
                    <input type="text" name="logradouro" id="logradouro"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Número</label>
                    <input type="text" name="numero"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Bairro</label>
                    <input type="text" name="bairro" id="bairro"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Município / Cidade</label>
                    <input type="text" name="cidade" id="cidade"  class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Estado (UF)</label>
                    <input type="text" name="estado" id="estado" maxlength="2" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm uppercase">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Complemento / Ponto de Referência</label>
                    <input type="text" name="complemento" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none font-bold text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center p-4">
            <a href="{{ route('associados.index') }}" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition">Cancelar</a>
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-black py-4 px-12 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-xs">
                Finalizar Cadastro
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
                // Preenche com "..." enquanto consulta
                document.getElementById('logradouro').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('estado').value = "...";

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(dados => {
                        if (!("erro" in dados)) {
                            document.getElementById('logradouro').value = dados.logradouro.toUpperCase();
                            document.getElementById('bairro').value = dados.bairro.toUpperCase();
                            document.getElementById('cidade').value = dados.localidade.toUpperCase();
                            document.getElementById('estado').value = dados.uf.toUpperCase();
                        } else {
                            alert("CEP não encontrado.");
                        }
                    });
            }
        }
    });
</script>
@endsection