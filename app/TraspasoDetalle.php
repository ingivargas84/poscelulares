<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoDetalle extends Model
{
    protected $table = 'traspasos_detalle';

    protected $fillable = [
        'cantidad',
        'producto_id',
        'imei',
        'traspasos_bodega_id',
    ];
}
