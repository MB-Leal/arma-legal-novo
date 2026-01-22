<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Exibe a tela de login/validação do associado
     */
    public function showAcesso()
    {
        if (session()->has('associado_id')) {
            return redirect()->route('associado.catalogo');
        }
        return view('auth.acesso');
    }

    /**
     * Valida os dados, limpa CPF e Nome, e cria a sessão
     */
    public function validarAssociado(Request $request)
    {
        // 1. Tratamento dos inputs (Limpeza)
        $nomeBusca = Str::upper(trim($request->nome_completo));
        $cpfBusca = preg_replace('/[^0-9]/', '', $request->cpf); // Remove pontos e traços

        // 2. Busca no banco de dados
        $associado = Associado::where('cpf', $cpfBusca)
            ->where('nome_completo', $nomeBusca)
            ->first();

        // 3. Verificação de sucesso
        if (!$associado) {
            return back()->withErrors([
                'erro' => 'Os dados informados não foram encontrados em nossa base de associados.'
            ])->withInput(); // Retorna mantendo o que foi digitado
        }

        // 4. Criação da Sessão (Segurança)
        // Guardamos o ID e o Nome para usar no sistema sem precisar consultar o banco toda hora
        Session::put('associado_id', $associado->id);
        Session::put('associado_nome', $associado->nome_completo);

        // 5. Redirecionamento para o Catálogo (View que vamos criar)
        return redirect()->route('associado.catalogo');
    }

    /**
     * Encerra a sessão do associado
     */
    public function logout()
    {
        Session::forget(['associado_id', 'associado_nome']);
        return redirect()->route('acesso.index');
    }
}
