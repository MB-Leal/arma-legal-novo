<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos_armas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('associado_id')->constrained('associados');
            $table->foreignId('modelo_id')->constrained('modelos_armas');

            // O número de série pode ser preenchido pela administração quando a fabricante enviar
            $table->string('numero_serie')->nullable();

            $table->enum('status_pedido', [
                'iniciado',
                'aguardando_pagamento',
                'pago',
                'em_fabricacao',
                'enviado_para_registro', // Fase onde o SIGMA seria gerado futuramente
                'concluido',
                'cancelado'
            ])->default('iniciado');

            $table->date('data_pedido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
