<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';

    protected $fillable = [
        'banco',
        'user_id',
        'estado_id'
    ];
}
