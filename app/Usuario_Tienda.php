<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_Tienda extends Model
{
    protected $table = 'usuarios_tiendas';

    protected $fillable = [
        'tienda_id',
        'user_id',
        'estado_id'
    ];
}
