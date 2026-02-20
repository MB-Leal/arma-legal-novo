<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModeloArma;

class ModeloArmaSeeder extends Seeder
{
    public function run(): void
    {
        $armas = [
            [
                'nome' => 'Pistola Taurus G3 T.O.R.O',
                'fabricante' => 'TAURUS',
                'modelo' => 'G3 T.O.R.O',
                'calibre' => '9mm',
                'capacidade' => '17+1',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '4"',
                'preco' => 3850.00,
                'descricao' => 'Pistola de percussor lançado, pronta para montagem de mira óptica.',
            ],
            [
                'nome' => 'Rifle CBC 7022 Way',
                'fabricante' => 'CBC',
                'modelo' => '7022 Way',
                'calibre' => '.22 LR',
                'capacidade' => '10 Tiros',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '18"',
                'preco' => 2450.00,
                'descricao' => 'Rifle leve, ideal para lazer e controle de pragas, coronha vazada.',
            ],
            [
                'nome' => 'Pistola Glock G17 Gen5',
                'fabricante' => 'GLOCK',
                'modelo' => 'G17 Gen5',
                'calibre' => '9mm',
                'capacidade' => '17+1',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '4.49"',
                'preco' => 8900.00,
                'descricao' => 'Referência mundial em confiabilidade, acabamento nDLC.',
            ],
            [
                'nome' => 'Revólver Taurus RT 856',
                'fabricante' => 'TAURUS',
                'modelo' => 'RT 856',
                'calibre' => '.38 SPL',
                'capacidade' => '6 Tiros',
                'sistema_funcionamento' => 'Repetição',
                'comprimento_cano' => '3"',
                'preco' => 3200.00,
                'descricao' => 'Compacto e robusto, ideal para porte velado.',
            ],
            [
                'nome' => 'Espingarda Boito Miura II',
                'fabricante' => 'BOITO',
                'modelo' => 'Miura II',
                'calibre' => '12',
                'capacidade' => '2 Tiros',
                'sistema_funcionamento' => 'Sobreposta',
                'comprimento_cano' => '28"',
                'preco' => 5600.00,
                'descricao' => 'Espingarda de canos sobrepostos para caça e esporte.',
            ],
            [
                'nome' => 'Pistola Beretta APX A1',
                'fabricante' => 'BERETTA',
                'modelo' => 'APX A1',
                'calibre' => '9mm',
                'capacidade' => '17+1',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '4.25"',
                'preco' => 6700.00,
                'descricao' => 'Chassi modular e ergonomia superior, padrão militar.',
            ],
            [
                'nome' => 'Rifle Mossberg 715T Tactical',
                'fabricante' => 'MOSSBERG',
                'modelo' => '715T',
                'calibre' => '.22 LR',
                'capacidade' => '25 Tiros',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '16.25"',
                'preco' => 4800.00,
                'descricao' => 'Design tático no estilo plataforma AR-15.',
            ],
            [
                'nome' => 'Pistola Imbel MD2 LX',
                'fabricante' => 'IMBEL',
                'modelo' => 'MD2 LX',
                'calibre' => '.380 ACP',
                'capacidade' => '19+1',
                'sistema_funcionamento' => 'Semiautomática',
                'comprimento_cano' => '5"',
                'preco' => 7400.00,
                'descricao' => 'Plataforma 1911 de alta capacidade, fabricação nacional.',
            ],
            [
                'nome' => 'Espingarda CBC Military 3.0',
                'fabricante' => 'CBC',
                'modelo' => 'Military 3.0',
                'calibre' => '12',
                'capacidade' => '7+1',
                'sistema_funcionamento' => 'Pump Action',
                'comprimento_cano' => '19"',
                'preco' => 4200.00,
                'descricao' => 'Espingarda operacional de alta resistência e cadência.',
            ],
            [
                'nome' => 'Revólver Smith & Wesson 686',
                'fabricante' => 'S&W',
                'modelo' => '686 Plus',
                'calibre' => '.357 Mag',
                'capacidade' => '7 Tiros',
                'sistema_funcionamento' => 'Repetição',
                'comprimento_cano' => '4"',
                'preco' => 16500.00,
                'descricao' => 'Lendário revólver em aço inoxidável, precisão extrema.',
            ],
        ];

        foreach ($armas as $arma) {
            ModeloArma::create($arma);
        }
    }
}