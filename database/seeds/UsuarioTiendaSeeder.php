<?php

use Illuminate\Database\Seeder;
use App\Usuario_Tienda;

class UsuarioTiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ut = new Usuario_Tienda();
        $ut->user_id = 1;
        $ut->tienda_id = 1;
        $ut->estado_id = 1;
        $ut->save();
    }
}
