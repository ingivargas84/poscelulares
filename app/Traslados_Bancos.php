<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traslados_Bancos extends Model
{
    protected $table = 'traspasos_banco';

    protected $fillable = [
        'tienda_origen_id',
        'tienda_destino_id',
        'banco_id',
        'monto',
        'user_id'
    ];
}
