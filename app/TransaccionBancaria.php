<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionBancaria extends Model
{
    protected $table = 'transaccion_bancaria';

    protected $fillable = [
        'tienda_id',
        'banco_id',
        'user_id',
        'tipo_transaccion_id',
        'movimiento',
        'monto_favor',
        'monto_total',
        'descripcion'
    ];
}
