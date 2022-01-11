<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table = 'estado_venta';

    protected $fillable = [
        'id',
        'estado_venta'
    ];
}
