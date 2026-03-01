@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Auditoria de Acessos</h1>
            <p class="text-slate-500 text-xs font-bold uppercase">Monitoramento de tentativas de login e segurança</p>
        </div>

        <form action="{{ route('admin.logs') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="CPF, Nome ou IP..." 
                   class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-xs font-bold outline-none focus:border-blue-900 w-64">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-black uppercase">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Data/Hora (Belém)</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Usuário/CPF</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Origem (IP)</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase text-center">Resultado</th>
                    <th class="p-4 text-[10px] font-black text-slate-400 uppercase">Dispositivo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-bold text-slate-600">
                        {{ $log->data_acesso->format('d/m/Y H:i:s') }}
                    </td>
                    <td class="p-4">
                        <div class="font-black text-slate-800 uppercase">{{ $log->nome ?? 'Desconhecido' }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase">CPF: {{ $log->cpf }}</div>
                    </td>
                    <td class="p-4 font-mono text-slate-500 text-[10px]">
                        {{ $log->ip_address }}
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $cores = [
                                'sucesso' => 'bg-green-100 text-green-700',
                                'inativo' => 'bg-amber-100 text-amber-700',
                                'nao_cadastrado' => 'bg-red-100 text-red-700'
                            ];
                            $labels = [
                                'sucesso' => 'Acesso OK',
                                'inativo' => 'Bloqueado (Inativo)',
                                'nao_cadastrado' => 'Não Encontrado'
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase {{ $cores[$log->resultado] ?? 'bg-slate-100' }}">
                            {{ $labels[$log->resultado] ?? $log->resultado }}
                        </span>
                    </td>
                    <td class="p-4 text-slate-400 text-[10px] max-w-xs truncate" title="{{ $log->user_agent }}">
                        {{ $log->user_agent }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-400 font-bold uppercase italic">Nenhum registro de acesso encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->appends(['search' => $search])->links() }}
    </div>
</div>
@endsection