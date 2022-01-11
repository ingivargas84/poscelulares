<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldos_Bancos extends Model
{
    protected $table = 'saldos_bancos';

    protected $fillable = [
        'tienda_id',
        'banco_id',
        'saldo_inicial',
        'saldo_real',
        'user_id'
    ];
}
