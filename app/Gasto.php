<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos';

    protected $fillable = [
        'id',
        'tienda_id',
        'descripcion',
        'monto',
        'documento',
        'rubro_gasto_id',
        'user_id',
        'estado_id',
    ];
}
