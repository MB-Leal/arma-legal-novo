<?php

namespace App\Http\Controllers;

use App\Models\PedidoArma;
use Illuminate\Http\Request;

class PedidoArmaController extends Controller
{
    // Associado inicia um pedido
    public function iniciarCompra(Request $request)
    {
        $pedido = PedidoArma::create([
            'associado_id' => auth()->user()->associado_id,
            'modelo_id' => $request->modelo_id,
            'status_pedido' => 'iniciado',
            'data_pedido' => now()
        ]);

        return redirect()->route('meus.pedidos')->with('status', 'Pedido realizado!');
    }

    // Administração atualiza o status ou insere Número de Série
    public function atualizarStatus(Request $request, $id)
    {
        $pedido = PedidoArma::findOrFail($id);

        // Se a arma chegou da fábrica, o admin insere o número de série
        if ($request->has('numero_serie')) {
            $pedido->numero_serie = $request->numero_serie;
            $pedido->status_pedido = 'enviado_para_registro';
        }

        $pedido->status_pedido = $request->status;
        $pedido->save();

        return back()->with('success', 'Pedido atualizado!');
    }
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
        //
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
