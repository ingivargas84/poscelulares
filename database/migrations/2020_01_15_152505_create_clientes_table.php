<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nit', 20)->required();
            $table->string('nombre_cliente')->required();
            $table->string('email')->nullable();
            $table->integer('dias_credito')->nullable();
            $table->string('direccion')->nullable();
            $table->date('fec_nacimiento')->nullable();
            $table->string('telefonos',50)->nullable();

            $table->unsignedInteger('estado')->default(1);
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
        Schema::dropIfExists('clientes');
    }
}
