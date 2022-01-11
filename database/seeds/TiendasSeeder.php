<?php

use Illuminate\Database\Seeder;
use App\Tienda;

class TiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = new Tienda();
        $t->tienda = "Variedades Melany 1";
        $t->descripcion = "Tienda principal ubicada en el centro de Jalpatagua";
        $t->estado_id = 1;
        $t->user_id = 1;
        $t->save();

        $t = new Tienda();
        $t->tienda = "Variedades Melany 2";
        $t->descripcion = "Tienda secundaria ubicada en el mercado de Jalpatagua";
        $t->estado_id = 1;
        $t->user_id = 1;
        $t->save();

        $t = new Tienda();
        $t->tienda = "Variedades Melany 3";
        $t->descripcion = "Tienda secundaria, ubicada en carretera hacia frontera con El Salvador";
        $t->estado_id = 1;
        $t->user_id = 1;
        $t->save();
    }
}
