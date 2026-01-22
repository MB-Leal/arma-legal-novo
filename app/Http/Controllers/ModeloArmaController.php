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
            'preco' => 'required|numeric',
            'foto_principal' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $modelo = ModeloArma::create($request->all());

        if ($request->hasFile('foto_principal')) {
            // Salva em storage/app/public/modelos
            $path = $request->file('foto_principal')->store('modelos', 'public');

            $modelo->imagens()->create([
                'caminho' => $path,
                'principal' => true
            ]);
        }

        return redirect()->route('modelos.index')->with('success', 'Modelo cadastrado!');
    }
}
