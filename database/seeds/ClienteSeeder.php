<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = new Cliente();
        $c->nit = "CF";
        $c->nombre_cliente = "No Aplica";
        $c->dias_credito = 0;
        $c->direccion = "Jalpatagua";
        $c->email = "noaplica@gmail.com";
        $c->estado = 1;
        $c->user_id = 1;
        $c->save();
    }
}
