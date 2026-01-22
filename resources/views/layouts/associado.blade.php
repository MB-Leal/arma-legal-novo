<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arma Legal - FASPM</title>

    <link rel="icon" href="{{ asset('imagens/armaLegal.ico') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">

                <a href="{{ route('associado.catalogo') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('imagens/arma.ico') }}" alt="Logo" class="h-10 bg-white rounded-full p-1">
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

    <footer class="bg-white border-t border-slate-200 py-6 mt-12">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center text-slate-500 text-xs font-bold uppercase tracking-widest">
            <div class="mb-4 md:mb-0">
                &copy; {{ date('Y') }} FASPM - Fundo de Assistência Social da PMPA
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-blue-900">Termos de Uso</a>
                <a href="#" class="hover:text-blue-900">Política de Privacidade (LGPD)</a>
                <a href="#" class="hover:text-blue-900">Suporte</a>
            </div>
        </div>
    </footer>

</body>

</html>