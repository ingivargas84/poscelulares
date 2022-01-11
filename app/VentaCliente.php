<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaCliente extends Model
{
    protected $table = 'ventas_clientes';

    protected $fillable = [
        'id',
        'pedido_maestro_id',
        'nit',
        'nombre',
        'direccion'
    ];
}
