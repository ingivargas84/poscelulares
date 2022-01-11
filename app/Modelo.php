<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelos';

    protected $fillable = [
        'id',
        'marca_id',
        'estado_id',
        'modelo'
    ];
}
