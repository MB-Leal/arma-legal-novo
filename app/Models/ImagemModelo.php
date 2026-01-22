<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagemModelo extends Model
{
    protected $table = 'imagens_modelos';

    protected $fillable = ['modelo_id', 'caminho', 'principal'];

    public function modelo()
    {
        return $this->belongsTo(ModeloArma::class, 'modelo_id');
    }
}
