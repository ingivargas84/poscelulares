<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $table = 'tipo_transaccion';

    protected $fillable = [
        'tipo_transaccion'
    ];
}
