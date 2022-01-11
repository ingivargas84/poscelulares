<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_Imei extends Model
{
    protected $table = 'productos_imei';

    protected $fillable = [
        'producto_id',
        'imei',
        'bodega_id',
        'estado_venta_id',
        'ingreso_detalle_id'
    ];
}
