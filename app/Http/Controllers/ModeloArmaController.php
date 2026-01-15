<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use Illuminate\Http\Request;

class ModeloArmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
