<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthAssociado
{
    public function handle(Request $request, Closure $next)
    {
        // Se não houver o ID do associado na sessão, manda de volta para a validação
        if (!Session::has('associado_id')) {
            return redirect()->route('acesso.index')->with('erro', 'Por favor, valide seus dados primeiro.');
        }

        return $next($request);
    }
}
