<?php

use Illuminate\Database\Seeder;
use App\Bodega;

class BodegasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $b = new Bodega();
        $b->nombre = "Bodega Principal y General";
        $b->descripcion = "Bodega Principal y General donde se distribuye hacia el resto de tiendas";
        $b->tipo = 1;
        $b->tienda_id = 1;
        $b->estado = 1;
        $b->user_id = 1;
        $b->save();

        $b = new Bodega();
        $b->nombre = "Bodega Melany 1";
        $b->descripcion = "Bodega Secundaria, producto para la venta y exhibición para tienda Melany 1";
        $b->tipo = 2;
        $b->tienda_id = 1;
        $b->estado = 1;
        $b->user_id = 1;
        $b->save();

        $b = new Bodega();
        $b->nombre = "Bodega Melany 2";
        $b->descripcion = "Bodega Secundaria, producto para la venta y exhibición para tienda Melany 2";
        $b->tipo = 2;
        $b->tienda_id = 3;
        $b->estado = 1;
        $b->user_id = 1;
        $b->save();

        $b = new Bodega();
        $b->nombre = "Bodega Melany 3";
        $b->descripcion = "Bodega Secundaria, producto para la venta y exhibición para tienda Melany 3";
        $b->tipo = 2;
        $b->tienda_id = 3;
        $b->estado = 1;
        $b->user_id = 1;
        $b->save();
    }
}
