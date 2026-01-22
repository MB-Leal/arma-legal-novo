<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    protected $table = 'fabricantes';
    protected $fillable = ['nome'];

    public function modelos()
    {
        return $this->hasMany(ModeloArma::class, 'fabricante_id');
    }
}
