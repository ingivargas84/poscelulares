<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion', 200);

            $table->unsignedInteger('tipo')->nullable();
            $table->foreign('tipo')->references('id')->on('tipos_bodega')->onDelete('cascade');

            $table->unsignedInteger('tienda_id')->nullable();
            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');

            $table->unsignedInteger('estado')->nullable()->default(1);
            $table->foreign('estado')->references('id')->on('estados')->onDelete('cascade');

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
        Schema::dropIfExists('bodegas');
    }
}
