<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoBodega extends Model
{
    protected $table = 'traspasos_bodega';

    protected $fillable = [
        'bodega_origen',
        'bodega_destino',
        'user_id'
    ];

    public function bodegaOrigen(){
        return $this->belongsTo('App\Bodega', 'bodega_origen');
    }

    public function bodegaDestino(){
        return $this->belongsTo('App\Bodega', 'bodega_destino');
    }


    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
