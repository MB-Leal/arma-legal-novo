<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoArma extends Model
{
            protected $table = 'tipos_arma'; 
            protected $fillable = ['nome'];
}
