<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Associado - Arma Legal</title>
    <link rel="icon" href="{{ asset('imagens/armaLegal.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/imask"></script>
    <style>
        .bg-login {
            /* Caminho para a imagem que você salvou */
            background-image: url('{{ asset("imagens/bg-policial.jpg") }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-login min-h-screen flex items-center justify-center relative">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 bg-white/95 p-8 rounded-lg shadow-2xl w-full max-w-md border-t-4 border-blue-900 backdrop-blur-sm">
        <div class="text-center mb-10">
            {{-- Logo com altura de aproximadamente 5cm --}}
            <img src="{{ asset('imagens/logo_tatica.png') }}"
                alt="Logo"
                class="mx-auto h-[190px] w-auto mb-6 object-contain drop-shadow-lg">

            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">
                Projeto Arma Legal
            </h1>
            <p class="text-blue-900 text-xs font-extrabold uppercase mt-2 tracking-widest">
                FASPM • Validação de Identidade
            </p>
        </div>

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-xs font-bold uppercase">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('acesso.validar') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nome Completo</label>
                <input type="text" name="nome_completo" required
                    class="w-full p-3 border border-slate-300 rounded focus:ring-2 focus:ring-blue-900 outline-none uppercase text-sm"
                    placeholder="DIGITE SEU NOME COMPLETO">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">CPF</label>
                <input type="text" id="cpf_input" name="cpf" required
                    class="w-full p-3 border border-slate-300 rounded focus:ring-2 focus:ring-blue-900 outline-none text-sm"
                    placeholder="000.000.000-00">
            </div>

            <button type="submit"
                class="w-full bg-blue-900 hover:bg-blue-800 text-white font-black py-4 rounded shadow-lg transition duration-200 uppercase tracking-widest text-sm">
                Validar e Acessar
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200 text-center">
            <p class="text-[10px] text-slate-400 font-bold uppercase">
                FASPM - Fundo de Assistência Social da PMPA <br>
                Sistema de Aquisição de Armas de Fogo
            </p>
        </div>
    </div>

    <script>
        // Máscara de CPF
        IMask(document.getElementById('cpf_input'), {
            mask: '000.000.000-00'
        });
    </script>
</body>

</html>