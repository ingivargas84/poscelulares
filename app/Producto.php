<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'descripcion',
        'marca_id',
        'modelo_id',
        'compania_id',
        'color',
        'presentacion',
        'precio_venta',
        'estado',
        'user_id'
    ];

    public function estado(){
        return $this->belongsTo('App\estados', 'estado');
    }

    public function presentacion(){
        return $this->belongsTo('App\PresentacionProducto', 'presentacion');
    }

    public function movimientosProducto(){
        return $this->hasMany('App\MovimientoProducto', 'producto_id', 'id');
    }

    public function ingresosDetalle(){
        return $this->hasMany('App\IngresoDetalle', 'producto_id', 'id');
    }

    public function pedidosDetalle(){
        return $this->hasMany('App\PedidoDetalle', 'producto_id', 'id');
    }
}
