<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->required();
            $table->string('descripcion',200)->required();

            $table->unsignedInteger('marca_id')->required();
            $table->foreign('marca_id')->references('id')->on('marcas');
            
            $table->unsignedInteger('modelo_id')->required();
            $table->foreign('modelo_id')->references('id')->on('modelos');

            $table->unsignedInteger('compania_id')->recompanias();
            $table->foreign('compania_id')->references('id')->on('companias');

            $table->unsignedInteger('presentacion')->required();
            $table->foreign('presentacion')->references('id')->on('presentaciones_producto');

            $table->decimal('precio_venta', 8, 2)->required();
            $table->integer('stock_maximo')->required();
            $table->integer('stock_minimo')->required();       

            $table->unsignedInteger('estado')->default(1)->required();
            $table->foreign('estado')->references('id')->on('estados');
            
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
        Schema::dropIfExists('productos');
    }
}
