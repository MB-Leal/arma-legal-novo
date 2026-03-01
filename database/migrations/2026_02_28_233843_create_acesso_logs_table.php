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
        Schema::create('acessos_logs', function (Blueprint $table) {
        $table->id();
        $table->string('cpf', 14)->index();
        $table->string('nome')->nullable();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        
        // Resultados: sucesso, falha_senha, nao_cadastrado, inativo
        $table->string('resultado'); 
        
        $table->boolean('eh_associado')->default(false);
        
        // Usamos timestamp para registrar o momento exato
        $table->timestamp('data_acesso');
        
        // timestamps padrão do Laravel (opcional, mas bom ter)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acesso_logs');
    }
};
