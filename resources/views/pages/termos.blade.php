@extends('layouts.associado') {{-- Ou o layout que você usa no catálogo --}}

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6 bg-white rounded-2xl shadow-sm my-10 border border-slate-100">
    <h1 class="text-2xl font-black text-slate-800 uppercase mb-6">Termos de Uso</h1>
    <div class="prose prose-slate max-w-none text-sm leading-relaxed text-slate-600 space-y-4">
        <p>Ao acessar o sistema da <strong>FASPM</strong>, o militar concorda em fornecer dados verídicos para a aquisição de armamentos.</p>
        <p>O uso das credenciais de acesso é pessoal e intransferível. Qualquer tentativa de fraude ou inserção de dados falsos resultará em sanções administrativas conforme o estatuto da corporação.</p>
        {{-- Adicione mais cláusulas conforme a necessidade jurídica do fundo --}}
    </div>
</div>
@endsection