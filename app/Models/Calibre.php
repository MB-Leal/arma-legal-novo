<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calibre extends Model
{
    protected $table = 'calibres';
    protected $fillable = ['nome'];

    public function modelos()
    {
        return $this->hasMany(ModeloArma::class, 'calibre_id');
    }
}
