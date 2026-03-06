<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arma Legal - Painel Admin</title>
    <link rel="icon" href="{{ asset('imagens/arma-de-fogo.ico') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 border-b border-slate-800 text-center">
                <img src="{{ asset('imagens/fas.png') }}" class="h-20 mx-auto mb-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Gestão de Armas</p>
            </div>

            <nav class="flex-1 p-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900' : 'hover:bg-slate-800' }} rounded-lg transition group">
                    <i class="fa-solid fa-chart-line mr-3 text-slate-400 group-hover:text-white"></i>
                    <span class="text-sm font-bold uppercase">Dashboard</span>
                </a>

                <a href="{{ route('pedidos.index') }}" class="flex items-center p-3 {{ request()->routeIs('pedidos.*') ? 'bg-blue-900' : 'hover:bg-slate-800' }} rounded-lg transition group">
                    <i class="fa-solid fa-cart-shopping mr-3 text-slate-400 group-hover:text-white"></i>
                    <span class="text-sm font-bold uppercase">Pedidos</span>
                </a>

                <a href="{{ route('modelos.index') }}" class="flex items-center p-3 {{ request()->routeIs('modelos.*') ? 'bg-blue-900' : 'hover:bg-slate-800' }} rounded-lg transition group">
                    <i class="fa-solid fa-gun mr-3 text-slate-400 group-hover:text-white"></i>
                    <span class="text-sm font-bold uppercase">Modelos de Armas</span>
                </a>
                <a href="{{ route('associados.index') }}" class="flex items-center p-3 {{ request()->routeIs('associados.*') ? 'bg-blue-900' : 'hover:bg-slate-800' }} rounded-lg transition group">
                    <i class="fa-solid fa-users mr-3 text-slate-400 group-hover:text-white"></i>
                    <span class="text-sm font-bold uppercase">Gestão de Associados</span>
                </a>
                <a href="{{ route('admin.usuarios.index') }}"
                    class="flex items-center p-3 {{ request()->routeIs('admin.usuarios.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg transition group">
                    <i class="fa-regular fa-user mr-3 {{ request()->routeIs('admin.usuarios.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                    <span class="text-sm font-bold uppercase">Gestão de Usuários</span>
                </a>
                <a href="{{ route('associado.catalogo') }}" class="flex items-center p-3 {{ request()->routeIs('associados.*') ? 'bg-blue-900' : 'hover:bg-slate-800' }} rounded-lg transition group">
                    <i class="fa-solid fa-eye mr-3 text-slate-400 group-hover:text-white"></i>
                    <span class="text-sm font-bold uppercase">Ver Catálogo</span>
                </a>
                <a href="{{ route('admin.logs') }}"
                    class="flex items-center p-3 {{ request()->routeIs('admin.logs') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-lg transition group">
                    <i class="fa-solid fa-shield-halved mr-3 {{ request()->routeIs('admin.logs') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                    <span class="text-sm font-bold uppercase">Logs de Acesso</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-red-400 hover:bg-red-900/20 rounded-lg transition font-bold text-xs uppercase">
                        <i class="fa-solid fa-right-from-bracket mr-3"></i> Sair
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 flex flex-col"> @if(isset($novosPedidosCount) && $novosPedidosCount > 0)
            <div class="bg-amber-400 p-2 text-center shadow-sm">
                <a href="{{ route('pedidos.index') }}" class="text-[10px] font-black text-amber-900 uppercase tracking-widest animate-pulse inline-block w-full">
                    <i class="fa-solid fa-bell mr-2"></i>
                    Atenção: Existem {{ $novosPedidosCount }} novos requerimentos aguardando análise!
                </a>
            </div>
            @endif

            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8 border-b border-slate-200">
                <div class="flex items-center text-slate-500">
                    <i class="fa-solid fa-bars md:hidden mr-4 cursor-pointer"></i>
                    <h2 class="text-sm font-black uppercase tracking-tighter text-slate-800">Projeto Arma Legal</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-xs font-bold text-slate-400 uppercase">Gestor: {{ Auth::user()->name ?? 'Administrador' }}</span>
                    <div class="w-8 h-8 bg-blue-900 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="p-8">
                @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 text-xs font-bold uppercase shadow-sm">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>