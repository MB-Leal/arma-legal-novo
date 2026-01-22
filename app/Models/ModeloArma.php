<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ModeloArma extends Model
{
    protected $table = 'modelos_armas';

    protected $fillable = [
        'nome',
        'tipo_arma_id',
        'fabricante_id',
        'calibre_id',
        'modelo',
        'capacidade',
        'sistema_funcionamento',
        'comprimento_cano',
        'preco',
        'descricao'
    ];

    // Taxas centralizadas
    const TAXA_VISTA = 0.05; // 5%
    const TAXA_PARCELADO = 0.10; // 10%

    protected function valorVista(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->preco * (1 + self::TAXA_VISTA),
        );
    }

    protected function valorParcelado(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->preco * (1 + self::TAXA_PARCELADO),
        );
    }

    // --- RELACIONAMENTOS ---
    public function tipo()
    {
        return $this->belongsTo(TipoArma::class, 'tipo_arma_id');
    }
    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class, 'fabricante_id');
    }
    public function calibre()
    {
        return $this->belongsTo(Calibre::class, 'calibre_id');
    }
    public function imagens()
    {
        return $this->hasMany(ImagemModelo::class, 'modelo_id');
    }
}
