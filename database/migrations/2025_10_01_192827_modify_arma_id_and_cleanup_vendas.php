<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            // Modifica o tipo de dado para unsignedBigInteger (deve funcionar agora)
            $table->unsignedBigInteger('arma_id')->change();
            
            // Remove a coluna redundante de nome do produto
            if (Schema::hasColumn('vendas', 'produto_nome')) {
                 $table->dropColumn('produto_nome');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->integer('arma_id')->change(); // Reverte o tipo
            $table->string('produto_nome', 255)->nullable(); // Recria a coluna redundante
        });
    }
};