<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Arma Legal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4" 
      style="background-image: linear-gradient(rgba(2, 6, 23, 0.9), rgba(2, 6, 23, 0.9)), url('{{ asset('imagens/banner-militar.jpg') }}'); background-size: cover; background-position: center;">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('imagens/logo_tatica.png') }}" alt="FASPM" class="h-48 mx-auto mb-4 drop-shadow-[0_0_5px_rgba(59,130,246,0.5)]">
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter italic">Painel <span class="text-blue-500">Admin</span></h1>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2">Gestão de Armas e Requerimentos</p>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/10 shadow-2xl">
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/50 p-4 rounded-xl mb-6">
                        <ul class="text-xs text-red-500 font-bold uppercase tracking-tight">
                            @foreach($errors->all() as $error)
                                <li><i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 ml-1 tracking-widest">Digite seu E-mail</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-4 text-slate-500 text-sm"></i>
                        <input type="email" name="email" required autofocus 
                               class="w-full bg-slate-950 border border-slate-800 rounded-2xl py-4 pl-12 pr-4 text-white text-sm focus:border-blue-600 outline-none transition-all placeholder:text-slate-700"
                               placeholder="admin@faspm.org.br">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase mb-2 ml-1 tracking-widest">Digite sua Senha de Acesso</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-4 text-slate-500 text-sm"></i>
                        <input type="password" name="password" required 
                               class="w-full bg-slate-950 border border-slate-800 rounded-2xl py-4 pl-12 pr-4 text-white text-sm focus:border-blue-600 outline-none transition-all placeholder:text-slate-700"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-900/20 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                    Acessar Sistema
                    <i class="fa-solid fa-right-to-bracket"></i>
                </button>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('acesso.index') }}" class="text-[10px] font-black text-slate-500 hover:text-blue-400 uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left-long"></i>
                Voltar para Acesso Associado
            </a>
        </div>
    </div>
</body>
</html>