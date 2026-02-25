@extends('layouts.associado')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="setupEndereco()">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">

        <div class="bg-blue-900 p-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold uppercase tracking-tight">Confirmação de Dados Oficiais</h2>
                <p class="text-blue-300 text-xs font-bold uppercase">Estes dados constarão no seu requerimento de aquisição</p>
            </div>
            <img src="{{ asset('imagens/logo_tatica.png') }}" class="h-12 brightness-0 invert">
        </div>

        <form action="{{ route('associado.finalizar') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <input type="hidden" name="modelo_id" value="{{ $modelo->id }}">
            <input type="hidden" name="parcelas" value="{{ $parcelas }}">

            <div>
                <h3 class="text-sm font-black text-slate-400 uppercase mb-4 border-b pb-2">Informações Funcionais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Posto / Graduação</label>
                        <input type="text" name="posto_graduacao" value="{{ $associado->posto_graduacao }}" required
                            class="w-full p-3 bg-slate-50 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unidade (OPM Atual)</label>
                        <input type="text" name="opm" value="{{ $associado->opm }}" required
                            class="w-full p-3 bg-slate-50 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase font-bold">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-black text-slate-400 uppercase mb-4 border-b pb-2">Endereço Residencial Atualizado</h3>
                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">CEP</label>
                        <div class="relative">
                            <input type="text" name="cep" x-model="cep" @keyup="formatarCep()" @blur="buscarViaCep()"
                                maxlength="9" required
                                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none font-bold"
                                placeholder="00000-000">
                            <div x-show="carregando" class="absolute right-3 top-3">
                                <svg class="animate-spin h-5 w-5 text-blue-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Logradouro (Rua/Avenida)</label>
                        <input type="text" name="logradouro" x-model="logradouro" required
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase text-sm font-semibold">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nº</label>
                        <input type="text" name="numero" value="{{ $associado->endereco->numero ?? '' }}" required
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none text-sm font-semibold">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bairro</label>
                        <input type="text" name="bairro" x-model="bairro" required
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase text-sm font-semibold">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cidade</label>
                        <input type="text" name="cidade" x-model="cidade" required
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase text-sm font-semibold">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">UF</label>
                        <input type="text" name="estado" x-model="estado" maxlength="2" required
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-900 outline-none uppercase text-sm font-bold text-center">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('associado.catalogo') }}" class="text-slate-400 hover:text-red-600 font-bold uppercase text-xs transition">
                    Cancelar e Voltar
                </a>
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-black py-4 px-12 rounded-xl shadow-xl transition uppercase tracking-widest text-sm">
                    Confirmar e Finalizar Pedido
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function setupEndereco() {
        return {
            cep: '{{ $associado->endereco->cep ?? "" }}',
            logradouro: '{{ $associado->endereco->logradouro ?? "" }}',
            bairro: '{{ $associado->endereco->bairro ?? "" }}',
            cidade: '{{ $associado->endereco->cidade ?? "" }}',
            estado: '{{ $associado->endereco->estado ?? "PA" }}',
            carregando: false,

            formatarCep() {
                this.cep = this.cep.replace(/\D/g, "").replace(/^(\d{5})(\d)/, "$1-$2");
            },

            async buscarViaCep() {
                let cepLimpo = this.cep.replace(/\D/g, "");
                if (cepLimpo.length !== 8) return;

                this.carregando = true;
                try {
                    const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
                    const data = await response.json();

                    if (!data.erro) {
                        this.logradouro = data.logradouro;
                        this.bairro = data.bairro;
                        this.cidade = data.localidade;
                        this.estado = data.uf;
                    } else {
                        alert("CEP não encontrado. Por favor, preencha manualmente.");
                    }
                } catch (error) {
                    console.error("Erro ao buscar CEP");
                } finally {
                    this.carregando = false;
                }
            }
        }
    }
</script>
@endsection