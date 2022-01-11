<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estado_facturacion');
            $table->date('fecha_ingreso');
            $table->string('no_pedido')->nullable();
            $table->float('subtotal');
            $table->float('total');

            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->unsignedInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('formas_pago');

            $table->float('porcentaje')->nullable()->default(0);
            $table->float('descuento_porcentaje')->nullable()->default(0);
            $table->float('descuento_valores')->nullable()->default(0);

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('bodega_id');
            $table->foreign('bodega_id')->references('id')->on('bodegas');

            $table->unsignedInteger('estado')->default(1);
            $table->foreign('estado')->references('id')->on('estados');

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
        Schema::dropIfExists('pedidos_maestro');
    }
}
