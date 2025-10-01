<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('armas', function (Blueprint $table) {
            // Adiciona as novas chaves estrangeiras. 
            // Elas são nullable (podem ser nulas) temporariamente
            // para que possamos migrar os dados em uma etapa separada.
            $table->foreignId('calibre_id')->nullable()->after('calibre')->constrained('calibres')->onDelete('set null');
            $table->foreignId('fabricante_id')->nullable()->after('fabricante')->constrained('fabricantes')->onDelete('set null');
            $table->foreignId('tipo_arma_id')->nullable()->after('tipo')->constrained('tipos_arma')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('armas', function (Blueprint $table) {
            // Remove as chaves estrangeiras em caso de rollback
            $table->dropForeign(['calibre_id']);
            $table->dropForeign(['fabricante_id']);
            $table->dropForeign(['tipo_arma_id']);
            
            $table->dropColumn(['calibre_id', 'fabricante_id', 'tipo_arma_id']);
        });
    }
};