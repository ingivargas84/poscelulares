<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegasMaxminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas_maxmin', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('tienda_id')->required();
            $table->foreign('tienda_id')->references('id')->on('tiendas');
            
            $table->unsignedInteger('producto_id')->required();
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->integer('stock_maximo')->required();
            $table->integer('stock_minimo')->required();      
            
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodegas_maxmin');
    }
}
