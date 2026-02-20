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

        $associados = Associado::when($search, function ($query, $search) {
            return $query->where('nome_completo', 'like', "%{$search}%")
                         ->orWhere('cpf', 'like', "%{$search}%");
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
        $request->validate([
            'nome_completo' => 'required',
            'cpf' => 'required|unique:associados,cpf',
            'matricula' => 'required|unique:associados,matricula',
            'cep' => 'required',
            'logradouro' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            $associado = Associado::create($request->only([
                'nome_completo', 'cpf', 'rg_militar', 'matricula', 
                'posto_graduacao', 'opm', 'status'
            ]));

            $associado->endereco()->create($request->only([
                'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'complemento'
            ]));
        });

        return redirect()->route('associados.index')->with('success', 'Associado cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $associado = Associado::with('endereco')->findOrFail($id);
        return view('admin.associados.edit', compact('associado'));
    }

    public function update(Request $request, $id)
    {
        $associado = Associado::findOrFail($id);
        
        DB::transaction(function () use ($request, $associado) {
            $associado->update($request->only([
                'nome_completo', 'rg_militar', 'posto_graduacao', 'opm', 'status'
            ]));

            $associado->endereco()->update($request->only([
                'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'complemento'
            ]));
        });

        return redirect()->route('associados.index')->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy($id)
    {
        $associado = Associado::findOrFail($id);
        $associado->delete(); // Soft Delete configurado na sua migration
        return redirect()->route('associados.index')->with('success', 'Associado removido.');
    }
}