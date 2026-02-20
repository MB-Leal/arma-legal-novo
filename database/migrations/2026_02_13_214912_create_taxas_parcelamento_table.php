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
        Schema::create('taxas_parcelamento', function (Blueprint $table) {
    $table->id();
    $table->integer('parcela')->unique(); // 1, 2, 3... 24
    $table->decimal('percentual', 8, 4); // Ex: 0.0090 (para 0.9%)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxas_parcelamento');
    }
};
