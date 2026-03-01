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
        Schema::create('associados', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('cpf', 11)->unique();
            $table->string('rg_militar')->unique()->nullable();
            $table->string('matricula')->unique();
            $table->string('posto_graduacao')->nullable();
            $table->string('opm')->nullable();
            $table->enum('status', ['ativo', 'veterano'])->default('ativo')->nullable();
            $table->string('email')->nullable();
        $table->string('celular')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
