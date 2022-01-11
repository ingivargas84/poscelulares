<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoRecargas extends Model
{
    protected $table = 'saldo_recargas';

    protected $fillable = [
        'id',
        'tienda_id',
        'producto_id',
        'compania_id',
        'entrada',
        'salida',
        'saldo',
        'user_id'
    ];
}
