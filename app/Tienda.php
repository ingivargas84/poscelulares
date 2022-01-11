<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';

    protected $fillable = [
        'tienda',
        'descripcion',
        'estado_id',
        'user_id'
    ];
}
