<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $table = 'facturas_detalle';

    protected $fillable = [
        'factura_id',
        'producto_id',
        'descripcion',
        'imei',
        'numero_tel',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

}
