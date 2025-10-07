<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoArma extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_arma'; // Nome correto no DB
    protected $fillable = ['nome']; // Permite a inserção de dados no Seeder
}
