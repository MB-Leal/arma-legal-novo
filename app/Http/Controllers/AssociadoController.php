<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;

class AssociadoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpf' => 'required|unique:associados',
            'matricula' => 'required|unique:associados',
            'nome_completo' => 'required',
            'cep' => 'required'
        ]);

        // Cria o associado
        $associado = Associado::create($request->only([
            'nome_completo',
            'cpf',
            'rg_militar',
            'matricula',
            'posto_graduacao',
            'opm'
        ]));

        // Cria o endereço vinculado
        $associado->endereco()->create($request->only([
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'cidade',
            'estado'
        ]));

        return response()->json(['message' => 'Associado cadastrado com sucesso'], 201);
    }
}
