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
    // 1. Limpeza do preço (Troca vírgula por ponto para o banco entender)
    $input = $request->all();

    if ($request->has('preco')) {
        $precoLimpo = str_replace(',', '.', str_replace('.', '', $request->preco));
        $request->merge(['preco' => $precoLimpo]);
    }

    // 2. Validação completa de todos os campos da migration
    $validatedData = $request->validate([
        'nome' => 'required|string|max:255',
        'fabricante' => 'required|string',
        'tipo' => 'required|string',
        'calibre' => 'required|string',
        'acabamento' => 'required|string',
        'capacidade_tiro' => 'required|string',
        'sistema_funcionamento' => 'required|string',
        'comprimento_cano' => 'required|string',
        'tipo_alma' => 'required|string',
        'qtd_raias' => 'required|integer',
        'sentido_raias' => 'required|string',
        'pais_fabricacao' => 'required|string',
        'preco' => 'required|numeric',
        'quantidade' => 'required|integer',
        'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,bmp,svg|max:5120'
    ]);

    // 3. Gravação usando os dados limpos
    // Garantimos que o preço salvo é o formatado (ponto decimal)
    $validatedData['preco'] = $input['preco'];
    $validatedData['nome'] = mb_strtoupper($validatedData['nome']);

    $modelo = ModeloArma::create($validatedData);

    // 4. Salva as imagens
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $index => $foto) {
            $path = $foto->store('modelos', 'public');
            $modelo->imagens()->create([
                'caminho' => $path,
                'principal' => ($index === 0)
            ]);
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
