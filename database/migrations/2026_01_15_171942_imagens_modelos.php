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
        Schema::create('imagens_modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_id')->constrained('modelos_armas')->onDelete('cascade');
            $table->string('caminho'); // Caminho no seu storage/app/public/modelos/...
            $table->boolean('principal')->default(false);
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
