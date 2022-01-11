<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosImeiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_imei', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->string('imei')->nullable();

            $table->unsignedInteger('bodega_id');
            $table->foreign('bodega_id')->references('id')->on('bodegas');

            $table->unsignedInteger('estado_venta_id');
            $table->foreign('estado_venta_id')->references('id')->on('estado_venta');

            $table->unsignedInteger('ingreso_detalle_id');
            $table->foreign('ingreso_detalle_id')->references('id')->on('ingresos_detalle');

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
        Schema::dropIfExists('productos_imei');
    }
}
