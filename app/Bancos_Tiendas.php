<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos_Tiendas extends Model
{
    protected $table = 'bancos_tiendas';

    protected $fillable = [
        'banco_id',
        'tienda_id'
    ];
}
