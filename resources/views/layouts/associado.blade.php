<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arma Legal - FASPM</title>

    <link rel="icon" href="{{ asset('imagens/armaLegal.ico') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Previne o scroll quando o modal estiver aberto */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">

                <a href="{{ route('associado.catalogo') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('imagens/arma-de-fogo.ico') }}" alt="Logo" class="h-10 bg-white rounded-full p-1">
                    <span class="font-extrabold text-xl tracking-tighter uppercase">Arma Legal</span>
                </a>

                <div class="hidden md:flex space-x-8 font-semibold uppercase text-sm">
                    <a href="{{ route('associado.catalogo') }}"
                        class="hover:text-blue-300 transition {{ request()->routeIs('associado.catalogo') ? 'border-b-2 border-white' : '' }}">
                        Catálogo de Armas
                    </a>
                    <a href="{{ route('associado.pedido') }}"
                        class="hover:text-blue-300 transition {{ request()->routeIs('associado.pedido') ? 'border-b-2 border-white' : '' }}">
                        Meus Pedidos
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-blue-200 uppercase font-bold">Logado como:</p>
                        <p class="text-sm font-bold uppercase">{{ Session::get('associado_nome') }}</p>
                    </div>
                    <form action="{{ route('acesso.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition uppercase shadow-md">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="bg-green-100 border-b border-green-200 text-green-700 px-4 py-3 text-center font-bold uppercase text-sm">
        {{ session('success') }}
    </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-10 mt-12">
    <div class="container mx-auto px-4">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 pb-8 border-b border-slate-100 gap-4 text-center md:text-left">
            
            <div class="max-w-md">
                <p class="text-[15px] font-bold text-slate-500 uppercase tracking-widest leading-loose">
                    Informações para o processo de Autorização para aquisição de armas de fogo da DAL 
                    <a href="{{ route('dal.info') }}" class="text-blue-600 hover:text-blue-800 underline transition-all ml-1">clicando aqui</a>
                </p>
            </div>

            <div class="max-w-md md:text-right">
                <p class="text-[15px] font-bold text-slate-500 uppercase tracking-widest leading-loose">
                    <a href="{{ asset('imagens/etapas.png') }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline transition-all mr-1">CLIQUE AQUI</a> 
                    para ver o passo a passo do Processo de Financiamento do FASPM.
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center text-slate-500 text-xs font-bold uppercase tracking-widest">
            <div class="mb-4 md:mb-0 text-[12px]">
                &copy; {{ date('Y') }} FASPM - Fundo de Assistência Social da PMPA
            </div>
            <div class="flex gap-6">
                <a href="{{ route('termos') }}" class="text-[10px] font-black text-slate-400 uppercase hover:text-blue-900 transition">Termos de Uso</a>
                <a href="{{ route('politica') }}" class="text-[10px] font-black text-slate-400 uppercase hover:text-blue-900 transition">Política de Privacidade (LGPD)</a>
                <a href="{{ route('suporte') }}" class="text-[10px] font-black text-slate-400 uppercase hover:text-blue-900 transition">Suporte</a>
            </div>
        </div>

    </div>
</footer>

</body>

</html>