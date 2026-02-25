@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Novo Modelo de Arma</h1>
        <p class="text-slate-500 text-xs font-bold uppercase">Preencha as especificações completas para o requerimento e catálogo</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
        <h4 class="text-red-500 font-black uppercase text-xs mb-2">Erro ao salvar:</h4>
        <ul class="list-disc list-inside text-red-500 text-[10px] font-bold uppercase">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('modelos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @csrf
        <div class="p-8 space-y-8">
            
            <div class="border-b border-slate-100 pb-6">
                <h3 class="text-blue-900 text-xs font-black uppercase mb-4 flex items-center">
                    <span class="bg-blue-900 text-white w-5 h-5 rounded-full flex items-center justify-center mr-2 text-[10px]">1</span>
                    Identificação do Modelo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Código da Arma</label>
                        <input type="text" name="codigo" placeholder="Opcional" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none uppercase font-bold text-sm transition" value="{{ old('codigo') }}">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Nome Comercial</label>
                        <input type="text" name="nome" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none uppercase font-bold text-sm transition" value="{{ old('nome') }}">
                    </div>
                </div>
            </div>

            <div class="border-b border-slate-100 pb-6">
                <h3 class="text-blue-900 text-xs font-black uppercase mb-4 flex items-center">
                    <span class="bg-blue-900 text-white w-5 h-5 rounded-full flex items-center justify-center mr-2 text-[10px]">2</span>
                    Especificações Técnicas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Fabricante</label>
                        <select name="fabricante" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm transition">
                            <option value="">SELECIONE...</option>
                            @foreach(['Taurus', 'Glock', 'Beretta', 'CBC', 'Boito', 'Imbel', 'Smith & Wesson', 'CZ', 'Sig Sauer', 'Springfield', 'IWI', 'Arex Defense'] as $fab)
                                <option value="{{ strtoupper($fab) }}">{{ strtoupper($fab) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Tipo de Arma</label>
                        <select name="tipo" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm transition">
                            <option value="">SELECIONE...</option>
                            <option value="PISTOLA">PISTOLA</option>
                            <option value="REVÓLVER">REVÓLVER</option>
                            <option value="ARMA LONGA">ARMA LONGA</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">País de Fabricação</label>
                        <select name="pais_fabricacao" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm transition">
                            <option value="">SELECIONE...</option>
                            @foreach(['Brasil', 'Austria', 'Estados Unidos', 'República Tcheca', 'suíço-alemã', 'Israel', 'Eslovênia'] as $pais)
                                <option value="{{ strtoupper($pais) }}">{{ strtoupper($pais) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Acabamento</label>
                        <select name="acabamento" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm transition">
                            <option value="">SELECIONE...</option>
                            <option value="OXIDADA">OXIDADA</option>
                            <option value="INOXIDÁVEL">INOXIDÁVEL</option>
                            <option value="CERAKOTE">CERAKOTE</option>
                            <option value="TENIFER / CARBONITRETAÇÃO">TENIFER / CARBONITRETAÇÃO</option>
                            <option value="PINTURA EPÓXI / ELETROSTÁTICA">PINTURA EPÓXI / ELETROSTÁTICA</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Calibre</label>
                        <input type="text" name="calibre" required placeholder="Ex: 9mm ou .40" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm uppercase" value="{{ old('calibre') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Capacidade de Tiro</label>
                        <input type="text" name="capacidade_tiro" required placeholder="Ex: 17+1" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm" value="{{ old('capacidade_tiro') }}">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Sistema de Funcionamento</label>
                        <input type="text" name="sistema_funcionamento" required placeholder="Ex: Semiautomática" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm uppercase" value="{{ old('sistema_funcionamento') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Qtd de Canos</label>
                        <input type="number" name="qtd_cano" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm" value="{{ old('qtd_cano') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Comprimento do Cano</label>
                        <input type="text" name="comprimento_cano" required placeholder="Ex: 102mm" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm uppercase" value="{{ old('comprimento_cano') }}">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Tipo de Alma</label>
                        <input type="text" name="tipo_alma" required placeholder="Ex: Raiada" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm uppercase" value="{{ old('tipo_alma') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Qtd de Raias</label>
                        <input type="number" name="qtd_raias" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm" value="{{ old('qtd_raias') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Sentido das Raias</label>
                        <input type="text" name="sentido_raias" required placeholder="Ex: Direita" class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm uppercase" value="{{ old('sentido_raias') }}">
                    </div>
                </div>
            </div>

            <div class="border-b border-slate-100 pb-6">
                <h3 class="text-blue-900 text-xs font-black uppercase mb-4 flex items-center">
                    <span class="bg-blue-900 text-white w-5 h-5 rounded-full flex items-center justify-center mr-2 text-[10px]">3</span>
                    Estoque e Situação
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Preço Base (Fábrica)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-400 font-bold text-sm">R$</span>
                            <input type="text" name="preco" required class="w-full p-3 pl-10 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm" placeholder="0,00" value="{{ old('preco') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Quantidade Atual</label>
                        <input type="number" name="quantidade" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm" value="{{ old('quantidade') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Estoque Mínimo</label>
                        <input type="number" name="estoque_minimo" value="5" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Situação</label>
                        <select name="situacao" required class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none font-bold text-sm transition">
                            <option value="ativo">ATIVO</option>
                            <option value="inativo">INATIVO</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-blue-900 text-xs font-black uppercase mb-4 flex items-center">
                    <span class="bg-blue-900 text-white w-5 h-5 rounded-full flex items-center justify-center mr-2 text-[10px]">4</span>
                    Mídias e Detalhes
                </h3>
                
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2">Observação (Opcional - Exibe no Catálogo)</label>
                    <textarea name="observacao" rows="3" placeholder="Informações extras para o associado..." class="w-full p-3 border-2 border-slate-100 rounded-lg focus:border-blue-900 outline-none text-sm"></textarea>
                </div>

                <label class="block text-[10px] font-black text-slate-500 uppercase mb-4">Fotos do Modelo (Máximo 3)</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for($i = 0; $i < 3; $i++)
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-blue-900 transition bg-slate-50">
                        <input type="file" name="fotos[]" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-900 file:text-white hover:file:bg-blue-800">
                        <p class="text-[9px] text-slate-400 mt-2 uppercase font-black">Foto {{ $i + 1 }} {{ $i == 0 ? '(Principal)' : '' }}</p>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="bg-slate-100 p-6 flex justify-between items-center border-t border-slate-200">
            <a href="{{ route('modelos.index') }}" class="text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition">Cancelar</a>
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-black py-4 px-12 rounded-xl shadow-lg transition uppercase tracking-widest text-xs">
                Salvar Modelo no Sistema
            </button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const precoInput = document.querySelector('input[name="preco"]');

    /**
     * Função para formatar moeda
     */
    function formatarMoeda(input) {
        let value = input.value.replace(/\D/g, ''); 
        if (value === "") return;
        
        value = (value / 100).toFixed(2) + '';
        value = value.replace(".", ",");
        value = value.replace(/(\d)(\d{3})(\d{3})/, "$1.$2.$3");
        value = value.replace(/(\d)(\d{3})/, "$1.$2");
        input.value = value;
    }

    // Formata o valor se ele já vier preenchido (ex: erro de validação)
    if (precoInput.value) {
        // Se vier com ponto (formato banco), limpa para formatar
        if(precoInput.value.includes('.')) {
            precoInput.value = precoInput.value.replace('.', '');
        }
        formatarMoeda(precoInput);
    }

    // Aplica a máscara visual enquanto o usuário digita
    precoInput.addEventListener('input', function(e) {
        formatarMoeda(e.target);
    });

    // Antes de enviar o formulário, limpa para o formato do banco (1234.56)
    const form = precoInput.closest('form');
    form.addEventListener('submit', function() {
        if(precoInput.value) {
            let cleanValue = precoInput.value.replace(/\./g, '').replace(',', '.');
            precoInput.value = cleanValue;
        }
    });
});
</script>
@endsection