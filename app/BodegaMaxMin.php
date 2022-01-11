<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodegaMaxMin extends Model
{
    protected $table = 'bodegas_maxmin';

    protected $fillable = [
        'tienda_id',
        'producto_id',
        'stock_maximo',
        'stock_minimo',
        'user_id'
    ];
}
