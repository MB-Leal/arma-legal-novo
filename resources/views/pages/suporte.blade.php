@extends('layouts.associado')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6 bg-white rounded-2xl shadow-sm my-10 border border-slate-200">
    <h1 class="text-2xl font-black text-slate-800 uppercase mb-6">Suporte ao Associado</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="p-6 bg-blue-50 rounded-xl border border-blue-100 text-center">
            <i class="fa-brands fa-whatsapp text-4xl text-green-500 mb-4"></i>
            <p class="font-black text-slate-800 uppercase mb-2">WhatsApp Suporte</p>
            <a href="https://wa.me/5591984211070" target="_blank" class="text-blue-600 font-bold">(91) 98421-1070</a>
        </div>
        <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 text-center">
            <i class="fa-solid fa-envelope text-4xl text-slate-400 mb-4"></i>
            <p class="font-black text-slate-800 uppercase mb-2">E-mail Desenvolvedor</p>
            <p class="text-slate-600 font-bold">tecnologia@faspmpa.com.br</p>
        </div>
    </div>
</div>
@endsection