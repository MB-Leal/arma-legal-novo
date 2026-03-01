@extends('layouts.associado') {{-- Ajustado para o layout que existe no seu projeto --}}

@section('content')
<main class="bg-gray-200 text-gray-900 min-h-screen">

    {{-- Banner Superior --}}
    <div class="h-[30vh] border-b-2 flex flex-wrap bg-cover bg-center shadow-inner" style="background-image: url('/imagens/fuzil.jpg');">
        {{-- Se a imagem acima não carregar via CSS, a img abaixo garante o visual --}}
        <img class="h-full w-full object-cover md:block hidden" src="/imagens/fuzil.jpg" alt="Capa Informativa" />
    </div>

    <div class="flex justify-center flex-col max-w-6xl mx-auto p-4 md:p-8">
        <h1 class="text-center font-black mb-2 text-3xl md:text-4xl uppercase text-slate-800 tracking-tighter">
            Processo de Autorização para Aquisição de Armas de Fogo <br>
            <span class="text-blue-900">Diretoria de Apoio Logístico - DAL</span>
        </h1>

        <a class="text-center text-blue-600 mb-8 font-bold hover:underline italic text-sm" href="https://www.pm.pa.gov.br/component/content/article/91-artigos-gerais/171-aquisicao-de-armas-de-fogo.html" target="_blank">
            (Mais informações detalhadas no site oficial da PMPA)
        </a>

        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 mb-8 leading-relaxed text-slate-700 text-justify">
            <p>
                A Diretoria de Apoio Logístico da PMPA, por meio da Subseção de Intendência e Subsistência, é o setor responsável pelos processos para aquisição, transferência e renovação dos Certificados de Registros de Arma de Fogo - CRAF, das armas particulares de propriedade dos policiais militares da PMPA, além da emissão do Porte de Arma de Fogo - PAF, para os policiais militares reformados e da reserva remunerada, conforme Portaria nº 069/2019 - GAB. CMDº (publicada no Aditamento nº 078 II, de 24 de abril de 2019).
            </p>
            <p class="mt-4">
                Com o objetivo de otimizar os processos de aquisições e torná-los mais céleres, informamos os procedimentos a serem adotados pelos militares adquirentes, quanto aos procedimentos para obtenção de CRAF's e PAF's, conforme abaixo discriminados.
            </p>
        </div>

        {{-- Accordion de Documentos --}}
        <div id="accordion-collapse" data-accordion="collapse" class="w-full lg:w-[85%] m-auto mb-10">
            <h2 id="accordion-collapse-heading-1">
                <button type="button" class="flex items-center justify-between w-full p-5 font-black text-left text-white bg-slate-900 rounded-t-2xl border border-slate-900 focus:ring-4 focus:ring-slate-200 hover:bg-slate-800 transition-all uppercase tracking-widest text-xs" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                    <span>Documentação Necessária - Aquisição de Arma (DAL)</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </h2>

            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div class="p-6 border border-t-0 border-slate-300 bg-white rounded-b-2xl">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <p class="text-xs font-bold text-blue-800 uppercase italic">
                            Obs: Recomenda-se que os documentos sejam baixados e preenchidos em computador/notebook, posteriormente escaneados e enviados via PAE na ordem abaixo:
                        </p>
                    </div>

                    <ul class="space-y-4 text-sm font-bold text-slate-700">
                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span>01 - Capa do processo com foto 3x4 (Fardado)</span>
                            <a href="{{ asset('pages/Capa de Processo de Aquisição.docx') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-blue-700 transition">Download</a>
                        </li>

                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span>02 - Requerimento padrão assinado pelo Diretor da DAL</span>
                            <a href="{{ asset('pages/REQUERIMENTO DE AQUISIÇÃO.docx') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-blue-700 transition">Download</a>
                        </li>

                        <li class="flex flex-col gap-2 p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="flex justify-between items-center w-full">
                                <span>03 - Declaração do CMT (Port. 069/2019)</span>
                                <a href="{{ asset('pages/Declaração do Comandante.docx') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-blue-700 transition">Download</a>
                            </div>
                            <span class="text-[9px] text-red-600 uppercase font-black">* Pode ser assinada eletronicamente via GOV.BR / ICP-Brasil</span>
                        </li>

                        <li class="p-3 bg-slate-50 rounded-lg border border-slate-100 opacity-60">
                            <span>04 - Identidade Militar (Cópia) LEGÍVEL</span>
                        </li>

                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span>05 - Comprovante de Residência ou Declaração</span>
                            <a href="{{ asset('pages/Declaração de Residência.docx') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-blue-700 transition">Download Modelo</a>
                        </li>

                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span>07 - Modelo de Preenchimento da GRU (Taxa Exército)</span>
                            <a href="{{ asset('pages/PREENCHIMENTO DA GRU.pdf') }}" class="bg-red-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-red-700 transition">Ver PDF</a>
                        </li>

                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100 font-black text-blue-800">
                            <span>08 - Certidão de Processo de Aquisição</span>
                            <a href="{{ asset('pages/Certidão de Processo de Aquisição.docx') }}" class="bg-blue-900 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-black transition shadow-md">Download</a>
                        </li>

                        <li class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <span>09 - Autorização do Diretor (Modelo)</span>
                            <a href="{{ asset('pages/Autorização do Diretor.docx') }}" class="bg-amber-600 text-white px-3 py-1 rounded text-[10px] uppercase font-black hover:bg-amber-700 transition">Download</a>
                        </li>
                    </ul>

                    <div class="mt-8 p-4 bg-slate-900 text-white rounded-xl text-center">
                        <h4 class="text-xs font-black uppercase mb-2 tracking-widest">Passo Final: Envio do Processo</h4>
                        <p class="text-[10px] font-bold uppercase mb-4 text-slate-400">Após reunir todos os documentos acima, envie via PAE para a DAL.</p>
                        <a href="https://www.sistemas.pa.gov.br/governodigital/public/main/index.xhtml" target="_blank" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg text-xs font-black uppercase hover:bg-blue-500 transition shadow-lg">
                            Acessar o Sistema PAE
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela GRU --}}
        <div class="max-w-4xl mx-auto w-full mb-12">
            <h2 class="text-center text-xl font-black text-slate-800 uppercase mb-6 tracking-widest">Dados para Gerar a Guia (GRU)</h2>
            <div class="overflow-hidden rounded-2xl border border-slate-300 shadow-xl">
                <table class="w-full text-center text-xs">
                    <thead class="bg-slate-800 text-white font-black uppercase">
                        <tr>
                            <th class="p-4 border-r border-slate-700">UG</th>
                            <th class="p-4 border-r border-slate-700">Gestão</th>
                            <th class="p-4 border-r border-slate-700">Unidade Gestora</th>
                            <th class="p-4 border-r border-slate-700">Código</th>
                            <th class="p-4">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white font-bold text-slate-700 italic">
                        <tr>
                            <td class="p-4 border-r border-slate-100">167086</td>
                            <td class="p-4 border-r border-slate-100">00001</td>
                            <td class="p-4 border-r border-slate-100">FUNDO DO EXÉRCITO</td>
                            <td class="p-4 border-r border-slate-100">11300-0</td>
                            <td class="p-4 font-black text-blue-900">R$ 25,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-center mt-4 text-[10px] font-black text-red-600 uppercase">* O PAGAMENTO DEVE SER REALIZADO EXCLUSIVAMENTE NO BANCO DO BRASIL.</p>
            <p class="text-center mt-4 text-[20px] font-black text-red-600 uppercase">
                <a href="https://pagtesouro.tesouro.gov.br/portal-gru/#/emissao-gru/formulario?ug=1670868codigoRecolhimento%3D11300-0">Site para emitir a GRU</a>
            </p>
        </div>

        <div class="text-center pb-20">
            <a href="{{ route('associado.catalogo') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-black transition-all hover:scale-105 active:scale-95 shadow-2xl">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Catálogo
            </a>
        </div>
    </div>

    {{-- Footer Manual (Para evitar erro de componente não encontrado) --}}
    <footer class="bg-slate-900 text-white pt-12">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 pb-12 border-b border-slate-800">
            <div class="space-y-4">
                <h3 class="text-lg font-black uppercase tracking-widest text-blue-400">Contatos do Setor</h3>
                <div class="text-xs font-bold space-y-2 uppercase text-slate-400">
                    <p><i class="fa-brands fa-whatsapp text-green-500 mr-2"></i> Armamento: (91) 98895-3551</p>
                    <p><i class="fa-brands fa-whatsapp text-green-500 mr-2"></i> Consignação: (91) 98895-3560</p>
                    <p><i class="fa-solid fa-envelope text-blue-500 mr-2"></i> projetoarmalegal@faspmpa.com.br</p>
                </div>
            </div>
            <div class="text-right space-y-4">
                <h3 class="text-lg font-black uppercase tracking-widest text-blue-400">Institucional</h3>
                <a href="https://faspmpa.com.br/" target="_blank" class="block text-xs font-bold uppercase hover:text-white transition text-slate-400">Site Oficial FASPM</a>
                <a href="{{ route('politica') }}" class="block text-xs font-bold uppercase hover:text-white transition text-slate-400">Privacidade (LGPD)</a>
            </div>
        </div>
        <div class="bg-black py-6 text-center text-[9px] font-black uppercase tracking-[0.3em] text-slate-600">
            &copy; {{ date('Y') }} FASPM - Fundo de Assistência Social da Polícia Militar do Pará
        </div>
    </footer>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.querySelector('[data-accordion-target="#accordion-collapse-body-1"]');
        const target = document.getElementById('accordion-collapse-body-1');
        const icon = btn.querySelector('[data-accordion-icon]');

        btn.addEventListener('click', function() {
            // Alterna a classe 'hidden' para mostrar/esconder
            const isHidden = target.classList.toggle('hidden');

            // Gira o ícone da seta
            if (isHidden) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }

            // Atualiza o atributo de acessibilidade
            btn.setAttribute('aria-expanded', !isHidden);
        });
    });
</script>
@endsection