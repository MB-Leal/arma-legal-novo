<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloArma extends Model
{
    use HasFactory;

    protected $table = 'modelos_armas';

    protected $fillable = [
    'codigo', 'nome', 'fabricante', 'tipo', 'calibre', 'acabamento', 
    'capacidade_tiro', 'sistema_funcionamento', 'qtd_cano', 'comprimento_cano', 
    'tipo_alma', 'qtd_raias', 'sentido_raias', 'pais_fabricacao', 'preco', 
    'situacao', 'quantidade', 'estoque_minimo', 'observacao'
];

    public function imagens()
    {
        return $this->hasMany(ImagemModelo::class, 'modelo_id');
    }
}