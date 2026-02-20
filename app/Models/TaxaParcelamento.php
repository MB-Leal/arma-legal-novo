<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxaParcelamento extends Model
{
    use HasFactory;

    protected $table = 'taxas_parcelamento';

    protected $fillable = [
        'parcela',
        'percentual'
    ];
}