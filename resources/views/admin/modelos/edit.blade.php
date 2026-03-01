@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Editar Armamento</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">{{ $modelo->nome }} | {{ $modelo->fabricante }}</p>
        </div>
        <a href="{{ route('modelos.index') }}" class="text-slate-400 hover:text-slate-600 text-[10px] font-black uppercase">
            &larr; Voltar para a lista
        </a>
    </div>

    {{-- Alertas de Erro --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
        <ul class="text-red-700 text-[10px] font-bold uppercase">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('modelos.update', $modelo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 font-black text-[10px] text-blue-900 uppercase">
                1. Identificação e Comercial
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nome Comercial</label>
                    <input type="text" name="nome" value="{{ old('nome', $modelo->nome) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none focus:border-blue-900 font-bold text-sm uppercase">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Fabricante</label>
                    <input type="text" name="fabricante" value="{{ old('fabricante', $modelo->fabricante) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none focus:border-blue-900 font-bold text-sm uppercase">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Preço Base (R$)</label>
                    <input type="text" name="preco" id="preco_edit" value="{{ old('preco', number_format($modelo->preco, 2, ',', '.')) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none focus:border-blue-900 font-bold text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 font-black text-[10px] text-blue-900 uppercase">
                2. Especificações Técnicas
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Tipo</label>
                        <input type="text" name="tipo" value="{{ old('tipo', $modelo->tipo) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Calibre</label>
                        <input type="text" name="calibre" value="{{ old('calibre', $modelo->calibre) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Acabamento</label>
                        <input type="text" name="acabamento" value="{{ old('acabamento', $modelo->acabamento) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Capacidade</label>
                        <input type="text" name="capacidade_tiro" value="{{ old('capacidade_tiro', $modelo->capacidade_tiro) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Sist. Funcionamento</label>
                        <input type="text" name="sistema_funcionamento" value="{{ old('sistema_funcionamento', $modelo->sistema_funcionamento) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Comprimento Cano</label>
                        <input type="text" name="comprimento_cano" value="{{ old('comprimento_cano', $modelo->comprimento_cano) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">País Origem</label>
                        <input type="text" name="pais_fabricacao" value="{{ old('pais_fabricacao', $modelo->pais_fabricacao) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl outline-none font-bold text-sm uppercase">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 font-black text-[10px] text-blue-900 uppercase">
                3. Detalhes do Cano
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Tipo de Alma</label>
                    <select name="tipo_alma" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-sm uppercase">
                        <option value="raiada" {{ old('tipo_alma', $modelo->tipo_alma) == 'raiada' ? 'selected' : '' }}>Raiada</option>
                        <option value="lisa" {{ old('tipo_alma', $modelo->tipo_alma) == 'lisa' ? 'selected' : '' }}>Lisa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Qtd Raias</label>
                    <input type="number" name="qtd_raias" value="{{ old('qtd_raias', $modelo->qtd_raias) }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Sentido Raias</label>
                    <select name="sentido_raias" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-sm uppercase">
                        <option value="direita" {{ old('sentido_raias', $modelo->sentido_raias) == 'direita' ? 'selected' : '' }}>Direita</option>
                        <option value="esquerda" {{ old('sentido_raias', $modelo->sentido_raias) == 'esquerda' ? 'selected' : '' }}>Esquerda</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 font-black text-[10px] text-blue-900 uppercase">
                4. Inventário e Mídia
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Quantidade Total</label>
                        <input type="number" name="quantidade" value="{{ old('quantidade', $modelo->quantidade) }}" required class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Novas Fotos (Opcional)</label>
                        <input type="file" name="fotos[]" multiple class="text-xs font-bold text-slate-400">
                    </div>
                </div>

                @if($modelo->imagens->count() > 0)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-4">Galeria Atual</p>
                    <div class="flex flex-wrap gap-4">
                        @foreach($modelo->imagens as $img)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $img->caminho) }}" class="h-20 w-20 object-cover rounded-lg border-2 border-slate-100">
                            @if($img->principal)
                                <div class="absolute -top-2 -right-2 bg-blue-600 text-white text-[7px] px-2 py-0.5 rounded-full font-black uppercase">Capa</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="flex justify-between items-center bg-slate-800 p-6 rounded-2xl shadow-xl">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Confira todos os dados antes de salvar</span>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-3 px-10 rounded-xl transition-all uppercase tracking-widest text-xs">
                Atualizar Modelo
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputPreco = document.getElementById('preco_edit');

        // Formatação de moeda (Máscara)
        inputPreco.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value === "") return;
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(\d{3})(\d{3})/, "$1.$2.$3");
            value = value.replace(/(\d)(\d{3})/, "$1.$2");
            e.target.value = value;
        });

        // Limpa antes de enviar para o banco entender (1234.56)
        inputPreco.closest('form').addEventListener('submit', function() {
            if(inputPreco.value) {
                inputPreco.value = inputPreco.value.replace(/\./g, '').replace(',', '.');
            }
        });
    });
</script>
@endsection