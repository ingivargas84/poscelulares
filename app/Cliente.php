<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'nit',
        'nombre_cliente',
        'email',
        'dias_credito',
        'direccion',
        'fec_nacimiento',
        'telefonos',
        'user_id',
        'estado'
    ];

    public function territorio(){
        return $this->belongsTo('App\territorios', 'territorio');
    }

    public function estado(){
        return $this->belongsTo('App\estados', 'estado');
    }

    public function pedidosMaestro(){

        return $this->hasMany('App\PedidoMaestro', 'cliente_id', 'id');
    }

    public function cuentaCobrarMaestro(){
        return $this->hasOne('App\CuentaCobrarMaestro', 'id_cliente', 'id');
    }
}
