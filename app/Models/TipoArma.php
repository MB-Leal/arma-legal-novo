<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArma extends Model
{
    protected $table = 'tipos_arma';
    protected $fillable = ['nome'];

    public function modelos()
    {
        return $this->hasMany(ModeloArma::class, 'tipo_arma_id');
    }
}
