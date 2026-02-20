<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaxaParcelamento;

class TaxaParcelamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxas = [
            1 => 0.0090,
            2 => 0.0136,
            3 => 0.0180,
            4 => 0.0226,
            5 => 0.0272,
            6 => 0.0319,
            7 => 0.0384,
            8 => 0.0432,
            9 => 0.0482,
            10 => 0.0530,
            11 => 0.0579,
            12 => 0.0629,
            13 => 0.0714,
            14 => 0.0767,
            15 => 0.0819,
            16 => 0.0871,
            17 => 0.0924,
            18 => 0.0977,
            19 => 0.1083,
            20 => 0.1140,
            21 => 0.1196,
            22 => 0.1252,
            23 => 0.1309,
            24 => 0.1366,
        ];

        foreach ($taxas as $p => $t) {
            TaxaParcelamento::create(['parcela' => $p, 'percentual' => $t]);
        }
    }
}
