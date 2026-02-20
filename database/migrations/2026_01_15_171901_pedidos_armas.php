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
            $table->string('numero_serie')->nullable();
            $table->integer('parcelas')->default(1);
            $table->decimal('valor_total', 10, 2)->nullable();
            $table->enum('status_pedido', [
                'iniciado',
                'pago',
                'em_fabricacao',
                'concluido',
                'cancelado'
            ])->default('iniciado');
            $table->date('data_pedido');
            $table->text('observacao_admin')->nullable();
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
