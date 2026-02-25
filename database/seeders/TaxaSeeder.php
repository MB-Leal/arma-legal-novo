<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 24; $i++) {
        \App\Models\Taxa::create([
            'parcela' => $i,
            'percentual' => $i * 0.0090, // 0,9% acumulado por parcela
        ]);
    }
    }
}
