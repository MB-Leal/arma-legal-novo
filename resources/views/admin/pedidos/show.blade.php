@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Detalhes do Pedido #{{ $pedido->id }}</h1>
        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-black text-xs uppercase">{{ $pedido->status_pedido }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-sm font-black text-slate-400 uppercase mb-6 border-b pb-2">Dados do Associado</h3>
                <div class="grid grid-cols-2 gap-y-4 text-sm">
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase">Nome Completo</p><p class="font-bold text-slate-800 uppercase">{{ $pedido->associado->nome_completo }}</p></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase">CPF</p><p class="font-bold text-slate-800">{{ $pedido->associado->cpf }}</p></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase">Matrícula</p><p class="font-bold text-slate-800">{{ $pedido->associado->matricula }}</p></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase">Posto/OPM</p><p class="font-bold text-slate-800 uppercase">{{ $pedido->associado->posto_graduacao }} / {{ $pedido->associado->opm }}</p></div>
                    <div><p class="text-[10px] font-bold text-slate-400 uppercase">Telefone / Celular</p><p class="font-bold text-slate-800">{{ $pedido->associado->celular }}</p></div>
        
        <div><p class="text-[10px] font-bold text-slate-400 uppercase">E-mail</p><p class="font-bold text-slate-800">{{ $pedido->associado->email }}</p></div>
                </div>

                <h3 class="text-sm font-black text-slate-400 uppercase mt-10 mb-6 border-b pb-2">Endereço de Entrega/Residência</h3>
                @if($pedido->associado->endereco)
                <div class="text-sm text-slate-600 uppercase font-semibold">
                    {{ $pedido->associado->endereco->logradouro }}, {{ $pedido->associado->endereco->numero }}<br>
                    {{ $pedido->associado->endereco->bairro }} - {{ $pedido->associado->endereco->cidade }}/{{ $pedido->associado->endereco->estado }}<br>
                    CEP: {{ $pedido->associado->endereco->cep }}
                </div>
                @else
                <p class="text-red-500 font-bold text-xs uppercase italic">Endereço não cadastrado.</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-blue-900 p-6 rounded-2xl shadow-lg text-white">
                <h3 class="text-xs font-black text-blue-300 uppercase mb-4 tracking-widest">Arma Solicitada</h3>
                <p class="text-xl font-black uppercase leading-tight mb-2">{{ $pedido->modelo->nome }}</p>
                <p class="text-xs font-bold text-blue-200 uppercase mb-6">{{ $pedido->modelo->fabricante }} - {{ $pedido->modelo->calibre }}</p>
                
                <div class="border-t border-white/10 pt-4 flex justify-between items-center">
    <span class="text-[10px] font-black uppercase tracking-widest text-blue-300/80">
        Preço Base (Catálogo)
    </span>
    <span class="font-bold text-white">
        R$ {{ number_format($pedido->modelo->preco, 2, ',', '.') }}
    </span>
</div>

<div class="border-t border-blue-500/30 pt-4 flex justify-between items-center">
    <span class="text-xs font-black uppercase tracking-tighter text-blue-200">
        Condições da venda
    </span>
    <div class="text-right">
        <span class="block text-lg font-black text-white italic leading-none">
            {{ $pedido->parcelas }}x de R$ {{ number_format($pedido->valor_parcela, 2, ',', '.') }}
        </span>
        <span class="text-[15px] font-black text-blue-400 uppercase tracking-widest">
            Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
        </span>
    </div>
</div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-4">Alterar Status do Pedido</label>
                <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <select name="status_pedido" class="w-full p-3 bg-slate-50 border rounded-lg font-bold text-xs uppercase outline-none focus:ring-2 focus:ring-blue-900">
                        <option value="iniciado" {{ $pedido->status_pedido == 'iniciado' ? 'selected' : '' }}>Iniciado</option>
                        <option value="pago" {{ $pedido->status_pedido == 'pago' ? 'selected' : '' }}>Pago / Confirmado</option>
                        <option value="concluido" {{ $pedido->status_pedido == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ $pedido->status_pedido == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <button type="submit" class="w-full bg-slate-800 text-white font-black py-3 rounded-lg text-[10px] uppercase hover:bg-black transition">Atualizar Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection