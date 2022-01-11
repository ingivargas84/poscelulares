<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoRecargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_recargas', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('tienda_id')->required();
            $table->foreign('tienda_id')->references('id')->on('tiendas');
            
            $table->unsignedInteger('producto_id')->required();
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->unsignedInteger('compania_id')->required();
            $table->foreign('compania_id')->references('id')->on('companias');

            $table->float('entrada')->nullable()->default(0);
            $table->float('salida')->nullable()->default(0);
            $table->float('saldo')->nullable()->default(0);
            
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
        Schema::dropIfExists('saldo_recargas');
    }
}
