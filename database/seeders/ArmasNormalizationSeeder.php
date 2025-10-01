<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Arma; // Assumindo que você criou o Model Arma
use App\Models\Calibre; // Assumindo que você criou o Model Calibre
use App\Models\Fabricante; // Assumindo que você criou o Model Fabricante
use App\Models\TipoArma; // Assumindo que você criou o Model TipoArma

class ArmasNormalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desativa a verificação de chaves estrangeiras temporariamente.
        // Isso é uma boa prática ao manipular dados durante migrações complexas.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->processNormalization('calibre', Calibre::class);
        $this->processNormalization('fabricante', Fabricante::class);
        $this->processNormalization('tipo', TipoArma::class, 'tipo_arma'); // 'tipo' para coluna antiga, 'tipo_arma' para nova tabela

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
    /**
     * Lógica genérica para migrar e atualizar um campo.
     * @param string $oldColumn Nome da coluna varchar em 'armas' (ex: 'calibre')
     * @param string $modelClass Model da nova tabela de referência (ex: Calibre::class)
     * @param string|null $newTableName Nome da nova tabela (se for diferente do nome da coluna)
     */
    private function processNormalization(string $oldColumn, string $modelClass, string $newTableName = null): void
    {
        $newTableName = $newTableName ?? $oldColumn; // Usa o nome da coluna se não for especificado
        $newIdColumn = $newTableName . '_id'; // Nome da nova FK: 'calibre_id'
        
        $this->command->info("Iniciando normalização para a coluna: {$oldColumn}...");

        // 1. Encontrar todos os valores únicos na coluna antiga
        $uniqueValues = DB::table('armas')
                            ->select($oldColumn)
                            ->whereNotNull($oldColumn)
                            ->distinct()
                            ->pluck($oldColumn);

        // 2. Inserir esses valores únicos na nova tabela de referência
        $map = [];
        foreach ($uniqueValues as $value) {
            // Insere o valor e obtém o novo ID
            $newModel = $modelClass::firstOrCreate(['nome' => trim($value)]);
            $map[trim($value)] = $newModel->id;
        }
        
        $this->command->info("Criados " . count($map) . " registros únicos na tabela '{$newTableName}'.");

        // 3. Atualizar a tabela 'armas' com as novas chaves estrangeiras (FK)
        foreach ($map as $oldValue => $newId) {
            DB::table('armas')
                ->where($oldColumn, trim($oldValue))
                ->update([$newIdColumn => $newId]);
        }
        
        $this->command->info("Tabela 'armas' atualizada com as chaves estrangeiras para '{$oldColumn}'.");
    }
}