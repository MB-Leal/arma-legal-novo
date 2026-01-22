<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Associado extends Model
{
    use SoftDeletes;

    protected $table = 'associados';

    protected $fillable = [
        'nome_completo',
        'cpf',
        'rg_militar',
        'matricula',
        'posto_graduacao',
        'opm',
        'status'
    ];

    // Relacionamento: Um associado tem um endereço
    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }

    // Relacionamento: Um associado pode ter vários pedidos
    public function pedidos()
    {
        return $this->hasMany(PedidoArma::class);
    }

    // Mutator para Nome (Sempre Caixa Alta)
    protected function nomeCompleto(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::upper(trim($value)),
        );
    }

    // Mutator para CPF (Apenas números)
    protected function cpf(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
}
