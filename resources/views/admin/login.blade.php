<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Arma Legal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('imagens/armaLegal.ico') }}">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    
    <div class="absolute inset-0 z-0 opacity-20">
        <img src="{{ asset('imagens/bg-policial.jpg') }}" class="w-full h-full object-cover">
    </div>

    <div class="relative z-10 bg-white p-8 md:p-12 rounded-2xl shadow-2xl w-full max-w-md border-b-8 border-blue-900">
        <div class="text-center mb-10">
            <img src="{{ asset('imagens/logo_tatica.png') }}" alt="Logo" class="mx-auto h-[120px] mb-6 object-contain">
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Acesso Administrativo</h1>
            <p class="text-blue-900 text-xs font-bold uppercase tracking-widest">Gestão de Pedidos e Arsenal</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-xs font-bold uppercase">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase mb-2">E-mail Institucional</label>
                <input type="email" name="email" required autofocus
                       class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none transition font-semibold"
                       placeholder="exemplo@email.com">
            </div>

            <div>
                <label class="block text-xs font-black text-slate-500 uppercase mb-2">Senha de Acesso</label>
                <input type="password" name="password" required
                       class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-900 outline-none transition"
                       placeholder="••••••••">
            </div>

            <button type="submit" 
                    class="w-full bg-blue-900 hover:bg-blue-800 text-white font-black py-4 rounded-xl shadow-lg transition duration-200 uppercase tracking-widest text-sm">
                Entrar no Painel
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('acesso.index') }}" class="text-[10px] font-black text-slate-400 hover:text-blue-900 uppercase tracking-widest transition">
                &larr; Voltar para Acesso Associado
            </a>
        </div>
    </div>
</body>
</html>