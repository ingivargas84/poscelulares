<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compania extends Model
{
    protected $table = 'companias';

    protected $fillable = [
        'compania',
        'estado_id'
    ];
}
