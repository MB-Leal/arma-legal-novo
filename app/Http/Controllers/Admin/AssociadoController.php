<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Associado;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssociadoController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // O segredo está no withTrashed()
    $associados = Associado::withTrashed() 
        ->when($search, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('matricula', 'like', "%{$search}%");
            });
        })
        ->orderBy('nome_completo', 'asc')
        ->paginate(15);

    return view('admin.associados.index', compact('associados', 'search'));
}

    public function create()
    {
        return view('admin.associados.create');
    }

public function store(Request $request)
{
    // 1. Validação: Apenas Nome, CPF e Matrícula são obrigatórios
    $validatedData = $request->validate([
        'nome_completo'   => 'required|string|max:255',
        'cpf'             => 'required|string|unique:associados,cpf',
        'matricula'       => 'required|string|unique:associados,matricula',
        
        // Todos os outros campos agora são nullable (opcionais)
        'rg_militar'      => 'nullable|string',
        'posto_graduacao' => 'nullable|string',
        'opm'             => 'nullable|string',
        'email'           => 'nullable|email|unique:associados,email',
        'celular'         => 'nullable|string',
        'status'          => 'nullable|in:ativo,inativo',
        
        // Dados do Endereço também opcionais
        'cep'             => 'nullable|string',
        'logradouro'      => 'nullable|string',
        'numero'          => 'nullable|string',
        'bairro'          => 'nullable|string',
        'cidade'          => 'nullable|string',
        'estado'          => 'nullable|string|max:2',
        'complemento'     => 'nullable|string'
    ]);

    try {
        DB::transaction(function () use ($request) {
            // 2. Cria o Associado (converte para maiúsculo apenas se houver valor)
            $associado = Associado::create([
                'nome_completo'   => mb_strtoupper($request->nome_completo),
                'cpf'             => $request->cpf,
                'matricula'       => $request->matricula,
                'rg_militar'      => $request->rg_militar,
                'posto_graduacao' => $request->posto_graduacao,
                'opm'             => $request->opm ? mb_strtoupper($request->opm) : null,
                'email'           => $request->email,
                'celular'         => $request->celular,
                'status'          => $request->status ?? 'ativo', // Padrão ativo se vazio
            ]);

            // 3. Cria o registro de Endereço vinculado
            $cepLimpo = $request->cep ? preg_replace('/\D/', '', $request->cep) : null;

            $associado->endereco()->create([
                'cep'         => $cepLimpo,
                'logradouro'  => $request->logradouro ? mb_strtoupper($request->logradouro) : null,
                'numero'      => $request->numero,
                'bairro'      => $request->bairro ? mb_strtoupper($request->bairro) : null,
                'cidade'      => $request->cidade ? mb_strtoupper($request->cidade) : null,
                'estado'      => $request->estado ? mb_strtoupper($request->estado) : null,
                'complemento' => $request->complemento ? mb_strtoupper($request->complemento) : null,
            ]);
        });

        return redirect()->route('associados.index')->with('success', 'Associado cadastrado com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors('Erro ao salvar no banco: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $associado = Associado::with('endereco')->findOrFail($id);
        return view('admin.associados.edit', compact('associado'));
    }

   public function update(Request $request, $id)
{
    $associado = Associado::findOrFail($id);
    
    // 1. Validação Flexível: Apenas Nome, CPF e Matrícula são obrigatórios
    // Nota: O e-mail também ganhou a regra de ignorar o ID atual para permitir salvar sem mudar
    $validatedData = $request->validate([
        'nome_completo'   => 'required|string|max:255',
        'cpf'             => 'required|string|unique:associados,cpf,' . $id,
        'matricula'       => 'required|string|unique:associados,matricula,' . $id,
        
        // Campos Opcionais (nullable)
        'rg_militar'      => 'nullable|string',
        'posto_graduacao' => 'nullable|string',
        'opm'             => 'nullable|string',
        'email'           => 'nullable|email|unique:associados,email,' . $id,
        'celular'         => 'nullable|string',
        'status'          => 'nullable|in:ativo,inativo',
        
        // Endereço Opcional
        'cep'             => 'nullable|string',
        'logradouro'      => 'nullable|string',
        'numero'          => 'nullable|string',
        'bairro'          => 'nullable|string',
        'cidade'          => 'nullable|string',
        'estado'          => 'nullable|string|max:2',
        'complemento'     => 'nullable|string'
    ]);

    try {
        DB::transaction(function () use ($request, $associado) {
            
            // 2. Atualiza dados do Associado (Maiúsculo apenas onde há texto)
            $associado->update([
                'nome_completo'   => mb_strtoupper($request->nome_completo),
                'cpf'             => $request->cpf,
                'matricula'       => $request->matricula,
                'rg_militar'      => $request->rg_militar,
                'posto_graduacao' => $request->posto_graduacao,
                'opm'             => $request->opm ? mb_strtoupper($request->opm) : null,
                'email'           => $request->email,
                'celular'         => $request->celular,
                'status'          => $request->status ?? $associado->status,
            ]);

            // 3. Prepara e atualiza o endereço
            $cepLimpo = $request->cep ? preg_replace('/\D/', '', $request->cep) : null;

            $associado->endereco()->update([
                'cep'         => $cepLimpo,
                'logradouro'  => $request->logradouro ? mb_strtoupper($request->logradouro) : null,
                'numero'      => $request->numero,
                'bairro'      => $request->bairro ? mb_strtoupper($request->bairro) : null,
                'cidade'      => $request->cidade ? mb_strtoupper($request->cidade) : null,
                'estado'      => $request->estado ? mb_strtoupper($request->estado) : null,
                'complemento' => $request->complemento ? mb_strtoupper($request->complemento) : null,
            ]);
        });

        return redirect()->route('associados.index')->with('success', 'Cadastro do associado atualizado com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->withErrors('Erro ao atualizar: ' . $e->getMessage());
    }
}

    public function destroy($id)
    {
        $associado = Associado::findOrFail($id);
        $associado->delete(); // Soft Delete configurado na sua migration
        return redirect()->route('associados.index')->with('success', 'Associado removido.');
    }

    public function restore($id)
{
    $associado = Associado::withTrashed()->findOrFail($id);
    $associado->restore(); // Isso remove a data do deleted_at e ele volta a "viver"

    return redirect()->route('associados.index')->with('success', 'Associado reativado com sucesso!');
}
}