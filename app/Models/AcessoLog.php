<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcessoLog extends Model
{
    protected $table = 'acessos_logs';

    protected $fillable = [
        'cpf',
        'nome',
        'ip_address',
        'user_agent',
        'resultado',
        'eh_associado',
        'data_acesso'
    ];

    // Indica que o campo data_acesso deve ser tratado como data
    protected $casts = [
        'data_acesso' => 'datetime',
        'eh_associado' => 'boolean',
    ];
}
