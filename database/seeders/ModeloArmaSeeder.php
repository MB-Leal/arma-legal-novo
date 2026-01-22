<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModeloArma;
use App\Models\ImagemModelo;

class ModeloArmaSeeder extends Seeder
{
    public function run(): void
    {
        // Modelo 1: Taurus G3
        $g3 = ModeloArma::create([
            'nome' => 'PISTOLA TAURUS G3 T.O.R.O.',
            'fabricante' => 'TAURUS',
            'modelo' => 'G3 T.O.R.O.',
            'calibre' => '9MM',
            'capacidade' => '17+1',
            'sistema_funcionamento' => 'SEMIAUTOMÁTICA',
            'comprimento_cano' => '102MM',
            'preco' => 4500.00,
            'taxa' => 150.00,
            'descricao' => 'Pistola striker fire ideal para defesa e serviço.'
        ]);

        // Vincula a imagem (Certifique-se que o arquivo existe em public/imagens/modelos/g3.png)
        $g3->imagens()->create([
            'caminho' => 'modelos/g3.png',
            'principal' => true
        ]);

        // Modelo 2: Glock G17
        $g17 = ModeloArma::create([
            'nome' => 'PISTOLA GLOCK G17 GEN5',
            'fabricante' => 'GLOCK',
            'modelo' => 'G17 GEN5',
            'calibre' => '9MM',
            'capacidade' => '17',
            'sistema_funcionamento' => 'SEMIAUTOMÁTICA',
            'comprimento_cano' => '114MM',
            'preco' => 8900.00,
            'taxa' => 150.00,
            'descricao' => 'A pistola mais utilizada por forças policiais no mundo.'
        ]);

        $g17->imagens()->create([
            'caminho' => 'modelos/g17.png',
            'principal' => true
        ]);

        // Modelo 3: Beretta APX
        $apx = ModeloArma::create([
            'nome' => 'PISTOLA BERETTA APX',
            'fabricante' => 'BERETTA',
            'modelo' => 'APX FULL SIZE',
            'calibre' => '9MM',
            'capacidade' => '17+1',
            'sistema_funcionamento' => 'SEMIAUTOMÁTICA',
            'comprimento_cano' => '108MM',
            'preco' => 7200.00,
            'taxa' => 150.00,
            'descricao' => 'Design ergonômico e modularidade superior.'
        ]);

        $apx->imagens()->create([
            'caminho' => 'modelos/apx.png',
            'principal' => true
        ]);
    }
}
