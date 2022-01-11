<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [
        'fecha_factura',
        'serie_factura',
        'no_factura',
        'subtotal',
        'impuestos',
        'total',
        'nit',
        'direccion',
        'nombre_factura',
        'motivo_anulacion',
        'user_anulacion',
        'fecha_anulacion',
        'estado',
        'pedido_maestro_id',
        'user_id'
    ];

    public function pedidoMaestro(){
        return $this->belongsTo('App\PedidoMaestro', 'pedido_maestro_id', 'id');
    }

}
