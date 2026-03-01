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
    // 1. Validação Completa de todos os campos do formulário
    $validatedData = $request->validate([
        'nome_completo'   => 'required|string|max:255',
        'cpf'             => 'required|string|unique:associados,cpf',
        'matricula'       => 'required|string|unique:associados,matricula',
        'rg_militar'      => 'required|string',
        'posto_graduacao' => 'required|string',
        'opm'             => 'required|string',
        'email'           => 'required|email|unique:associados,email',
        'celular'         => 'required|string',
        'status'          => 'required|in:ativo,inativo',
        
        // Dados do Endereço
        'cep'             => 'required|string',
        'logradouro'      => 'required|string',
        'numero'          => 'required|string',
        'bairro'          => 'required|string',
        'cidade'          => 'required|string',
        'estado'          => 'required|string|max:2',
        'complemento'     => 'nullable|string'
    ]);

    try {
        DB::transaction(function () use ($request) {
            // 2. Cria o Associado com os campos validados
            $associado = Associado::create([
                'nome_completo'   => mb_strtoupper($request->nome_completo),
                'cpf'             => $request->cpf,
                'matricula'       => $request->matricula,
                'rg_militar'      => $request->rg_militar,
                'posto_graduacao' => $request->posto_graduacao,
                'opm'             => $request->opm,
                'email'           => $request->email,
                'celular'         => $request->celular,
                'status'          => $request->status,
            ]);

            // 3. Cria o Endereço vinculado (limpando o CEP)
            $associado->endereco()->create([
                'cep'         => preg_replace('/\D/', '', $request->cep),
                'logradouro'  => mb_strtoupper($request->logradouro),
                'numero'      => $request->numero,
                'bairro'      => mb_strtoupper($request->bairro),
                'cidade'      => mb_strtoupper($request->cidade),
                'estado'      => mb_strtoupper($request->estado),
                'complemento' => mb_strtoupper($request->complemento),
            ]);
        });

        return redirect()->route('associados.index')->with('success', 'Associado cadastrado com sucesso!');

    } catch (\Exception $e) {
        // Se der qualquer erro de banco, ele volta com a mensagem de erro técnica
        return redirect()->back()->withInput()->withErrors('Erro no banco de dados: ' . $e->getMessage());
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
    
    // 1. Validação dos dados (Garante que CPF e MF sejam únicos, ignorando o ID atual)
    $validatedData = $request->validate([
        'nome_completo'   => 'required|string|max:255',
        'cpf'             => 'required|string|unique:associados,cpf,' . $id,
        'matricula'       => 'required|string|unique:associados,matricula,' . $id,
        'rg_militar'      => 'required|string',
        'posto_graduacao' => 'required|string',
        'opm'             => 'required|string',
        'email'           => 'required|email',
        'celular'         => 'required|string',
        'status'          => 'required|in:ativo,inativo',
        
        // Validação do endereço
        'cep'             => 'required|string',
        'logradouro'      => 'required|string',
        'numero'          => 'required|string',
        'bairro'          => 'required|string',
        'cidade'          => 'required|string',
        'estado'          => 'required|string|max:2',
    ]);

    DB::transaction(function () use ($request, $associado) {
        // 2. Atualiza os dados do Associado (Agora incluindo CPF e Matrícula)
        $associado->update($request->only([
            'nome_completo', 
            'cpf', 
            'matricula', 
            'rg_militar', 
            'posto_graduacao', 
            'opm', 
            'email', 
            'celular', 
            'status'
        ]));

        // 3. Limpeza do CEP antes de salvar
        $dadosEndereco = $request->only([
            'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'complemento'
        ]);
        $dadosEndereco['cep'] = preg_replace('/\D/', '', $dadosEndereco['cep']);

        // 4. Atualiza o endereço relacionado
        $associado->endereco()->update($dadosEndereco);
    });

    return redirect()->route('associados.index')->with('success', 'Cadastro do associado atualizado com sucesso!');
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