<?php

namespace App\Http\Controllers;

use App\Models\ModeloArma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloArmaController extends Controller
{
    // Listar vitrine de armas para o associado
    public function index()
    {
        $modelos = ModeloArma::with('imagens')->get();
        return view('modelos.index', compact('modelos'));
    }

    // Salvar novo modelo com imagem no Storage
    public function store(Request $request)
    {
        $request->validate([
        'nome' => 'required',
        'fabricante' => 'required',
        'preco' => 'required|numeric',
        'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Valida cada foto no array
    ]);

        $modelo = ModeloArma::create($request->all());

        if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $index => $foto) {
            $caminho = $foto->store('modelos', 'public');
            
            $modelo->imagens()->create([
                'caminho' => $caminho,
                'principal' => ($index === 0) // Define a primeira foto como principal
            ]);
        }
    }

        return redirect()->route('modelos.index')->with('success', 'Modelo cadastrado!');
    }
}
