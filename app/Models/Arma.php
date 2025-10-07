<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    use HasFactory;
    
    protected $guarded = ['id']; 

    public function calibre()
    {
        return $this->belongsTo(Calibre::class);
    }

    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    public function tipoArma()
    {
        return $this->belongsTo(TipoArma::class, 'tipo_arma_id'); 
    }
}