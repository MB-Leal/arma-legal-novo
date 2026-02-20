<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Adicionado para verificar o login do admin

class AuthAssociado
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se é um associado (pela sessão) OU se é um administrador (pelo login)
        $isAssociado = Session::has('associado_id');
        $isAdmin = Auth::check() && Auth::user()->is_admin;

        if ($isAssociado || $isAdmin) {
            return $next($request);
        }

        // Se nenhum dos dois for verdadeiro, manda para a validação
        return redirect()->route('acesso.index')->with('erro', 'Por favor, valide seus dados primeiro.');
    }
}