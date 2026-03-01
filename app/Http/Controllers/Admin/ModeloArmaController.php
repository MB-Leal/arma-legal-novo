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
    public function index(Request $request): View
{
    // 1. Pegamos a lista de todos os fabricantes únicos para preencher o Select
    $fabricantes = ModeloArma::distinct()->pluck('fabricante')->sort();

    // 2. Iniciamos a query dos modelos
    $query = ModeloArma::with('imagens')->orderBy('nome');

    // 3. Se houver filtro de fabricante na URL, aplicamos
    if ($request->has('fabricante') && $request->fabricante != '') {
        $query->where('fabricante', $request->fabricante);
    }

    $modelos = $query->get();

    return view('admin.modelos.index', compact('modelos', 'fabricantes'));
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
    // 1. Limpeza do preço (Trata formatos 5.045,00 ou 5045.00)
    if ($request->has('preco')) {
        $precoRaw = $request->preco;
        
        // Se houver vírgula, tratamos como formato BR (Ex: 1.234,56)
        if (strpos($precoRaw, ',') !== false) {
            $precoLimpo = str_replace('.', '', $precoRaw); // Remove ponto de milhar
            $precoLimpo = str_replace(',', '.', $precoLimpo); // Troca vírgula decimal por ponto
        } else {
            // Se não houver vírgula, apenas garantimos que seja um valor numérico limpo
            $precoLimpo = $precoRaw;
        }
        
        // Injeta o valor limpo de volta no request para a validação 'numeric' funcionar
        $request->merge(['preco' => $precoLimpo]);
    }

    // 2. Validação completa
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

    // 3. Preparação dos dados para gravação
    // Usamos o 'preco' que já foi validado e está limpo no $validatedData
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
    // 1. Limpeza do preço (mesma lógica do store para garantir o formato decimal)
    if ($request->has('preco')) {
        $precoRaw = $request->preco;
        if (strpos($precoRaw, ',') !== false) {
            $precoLimpo = str_replace('.', '', $precoRaw);
            $precoLimpo = str_replace(',', '.', $precoLimpo);
        } else {
            $precoLimpo = $precoRaw;
        }
        $request->merge(['preco' => $precoLimpo]);
    }

    $modelo = ModeloArma::findOrFail($id);

    // 2. Validação COMPLETA (incluindo quantidade e todos os campos técnicos)
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
        'quantidade' => 'required|integer', // AQUI ESTAVA O ERRO: Faltava validar para o Laravel aceitar
        'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,bmp,svg|max:5120'
    ]);

    // 3. Formatação adicional
    $validatedData['nome'] = mb_strtoupper($validatedData['nome']);

    // 4. Atualização no Banco de Dados
    $modelo->update($validatedData);

    // 5. Gestão de Novas Imagens (se o gestor subiu fotos novas)
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store('modelos', 'public');
            
            // Se o modelo não tinha nenhuma imagem antes, a primeira nova vira a principal
            $isFirst = $modelo->imagens()->count() === 0;
            
            $modelo->imagens()->create([
                'caminho' => $path,
                'principal' => $isFirst
            ]);
        }
    }

    return redirect()->route('modelos.index')->with('success', 'Modelo atualizado com sucesso!');
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
