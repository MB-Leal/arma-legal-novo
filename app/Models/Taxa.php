<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxa extends Model
{
    // Nome da tabela (opcional se for 'taxas', mas bom garantir)
    protected $table = 'taxas';

    // Campos que podem ser preenchidos
    protected $fillable = ['parcela', 'percentual'];
}