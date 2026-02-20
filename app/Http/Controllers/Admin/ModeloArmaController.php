<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModeloArma;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModeloArmaController extends Controller
{
    /**
     * Lista os modelos cadastrados
     */
    public function index(): View
    {
        // O orderBy() é um método do Eloquent. 
        // Se o erro persistir no editor, ignore-o ou use ModeloArma::query()->orderBy...
        $modelos = ModeloArma::orderBy('nome')->get();

        return view('admin.modelos.index', compact('modelos'));
    }

    /**
     * Tela de criação
     */
    public function create(): View
    {
        return view('admin.modelos.create');
    }

    /**
     * Salva o novo modelo
     */
    public function store(Request $request)
    {
        // 1. Validação rigorosa para evitar erros de banco
        $request->validate([
            'nome' => 'required',
            'fabricante' => 'required',
            'tipo' => 'required',
            'calibre' => 'required',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. Gravação dos dados técnicos
        $modelo = ModeloArma::create($request->all());

        // 3. Gravação das até 3 imagens
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $foto) {
                if ($index < 3) { // Garante o limite de 3
                    $caminho = $foto->store('modelos', 'public');
                    $modelo->imagens()->create([
                        'caminho' => $caminho,
                        'principal' => ($index === 0) // A primeira é a principal
                    ]);
                }
            }
        }

        return redirect()->route('modelos.index')->with('success', 'Modelo cadastrado com sucesso!');
    }

    /**
     * Tela de edição
     */
    public function edit($id): View
    {
        $modelo = ModeloArma::findOrFail($id);
        return view('admin.modelos.edit', compact('modelo'));
    }

    /**
     * Atualiza os dados no banco
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $modelo = ModeloArma::findOrFail($id);

        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'fabricante' => 'required|string',
            'preco'      => 'required|numeric',
        ]);

        $dados['nome'] = mb_strtoupper($dados['nome']);

        $modelo->update($dados);

        return redirect()->route('modelos.index')->with('success', 'Modelo atualizado!');
    }

    /**
     * Remove um modelo
     */
    public function destroy($id): RedirectResponse
    {
        $modelo = ModeloArma::findOrFail($id);
        $modelo->delete();

        return redirect()->route('modelos.index')->with('success', 'Modelo excluído com sucesso!');
    }
}
