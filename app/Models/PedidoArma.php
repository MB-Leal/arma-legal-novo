<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoArma extends Model
{
    protected $table = 'pedidos_armas';

    protected $fillable = [
        'associado_id',
        'modelo_id',
        'numero_serie',
        'status_pedido',
        'data_pedido'
    ];

    // Cast para data automática
    protected $casts = [
        'data_pedido' => 'date',
    ];

    public function associado()
    {
        return $this->belongsTo(Associado::class);
    }

    public function modelo()
    {
        return $this->belongsTo(ModeloArma::class, 'modelo_id');
    }
}
