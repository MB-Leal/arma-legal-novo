<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('armas', function (Blueprint $table) {
            // Remove as colunas VARCHAR antigas, pois os dados foram migrados para as colunas _id
            $table->dropColumn('calibre');
            $table->dropColumn('fabricante');
            $table->dropColumn('tipo');
        });
    }

    public function down(): void
    {
        // Ao reverter (rollback), as colunas VARCHAR devem ser recriadas.
        Schema::table('armas', function (Blueprint $table) {
            $table->string('calibre', 100)->nullable();
            $table->string('fabricante', 100)->nullable();
            $table->string('tipo', 100)->nullable();
        });
    }
};