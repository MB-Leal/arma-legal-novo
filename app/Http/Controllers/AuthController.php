<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\AcessoLog;

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
        $nomeDigitado = Str::upper(trim($request->nome_completo));
        $cpfBusca = preg_replace('/[^0-9]/', '', $request->cpf);

        // 2. Busca o associado INCLUINDO os excluídos para sabermos quem está tentando entrar
        $associado = Associado::withTrashed()
            ->where('cpf', $cpfBusca)
            ->where('nome_completo', $nomeDigitado)
            ->first();

        // Preparação dos dados básicos do LOG
        $dadosLog = [
            'cpf'          => $cpfBusca,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'data_acesso'  => now(), // Horário de Belém já configurado!
        ];

        // 3. Verificação de existência e status
        
        // CASO A: Não existe no banco de dados
        if (!$associado) {
            AcessoLog::create(array_merge($dadosLog, [
                'nome'         => $nomeDigitado . " (TENTATIVA)",
                'resultado'    => 'nao_cadastrado',
                'eh_associado' => false
            ]));

            return back()->withErrors([
                'erro' => 'Os dados informados não foram encontrados em nossa base de associados.'
            ])->withInput();
        }

        // CASO B: Existe, mas foi EXCLUÍDO (Soft Delete)
        if ($associado->trashed()) {
            AcessoLog::create(array_merge($dadosLog, [
                'nome'         => $associado->nome_completo,
                'resultado'    => 'inativo',
                'eh_associado' => true
            ]));

            return back()->withErrors([
                'erro' => 'Seu cadastro está inativo no sistema. Procure a administração.'
            ])->withInput();
        }

        // CASO C: Sucesso (Existe e está ativo)
        AcessoLog::create(array_merge($dadosLog, [
            'nome'         => $associado->nome_completo,
            'resultado'    => 'sucesso',
            'eh_associado' => true
        ]));

        // 4. Criação da Sessão
        Session::put('associado_id', $associado->id);
        Session::put('associado_nome', $associado->nome_completo);

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

    // Exibe a tela de login admin
    public function showAdminLogin()
    {
        return view('admin.login');
    }

    // Processa o login (Marcos/Adriano)
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Verifica se é admin (conforme campo na migration que criamos)
            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Acesso negado. Usuário não é administrador.']);
        }

        return back()->withErrors(['email' => 'As credenciais informadas estão incorretas.']);
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
