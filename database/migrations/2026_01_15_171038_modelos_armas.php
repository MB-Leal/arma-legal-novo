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
            $table->string('nome'); // Ex: Pistola G3 T.O.R.O
            $table->string('fabricante');
            $table->string('modelo');
            $table->string('calibre');
            $table->string('capacidade'); // Ex: 17+1
            $table->string('sistema_funcionamento'); // Ex: Semiautomática
            $table->string('comprimento_cano');
            $table->decimal('preco', 10, 2);
            $table->decimal('taxa', 10, 2);
            $table->text('descricao')->nullable();
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
