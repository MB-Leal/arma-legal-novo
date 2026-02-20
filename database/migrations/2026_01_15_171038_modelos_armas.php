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
        Schema::create('modelos_armas', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->nullable();
        $table->string('nome');
        $table->string('fabricante');
        $table->string('tipo'); // Pistola, Revólver, etc.
        $table->string('calibre');
        $table->string('acabamento');
        $table->string('capacidade_tiro');
        $table->string('sistema_funcionamento');
        $table->integer('qtd_cano')->default(1);
        $table->string('comprimento_cano');
        $table->string('tipo_alma');
        $table->integer('qtd_raias');
        $table->string('sentido_raias');
        $table->string('pais_fabricacao');
        $table->decimal('preco', 10, 2);
        $table->string('situacao')->default('ativo');
        $table->integer('quantidade')->default(0);
        $table->integer('estoque_minimo')->default(5);
        $table->text('observacao')->nullable();
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
