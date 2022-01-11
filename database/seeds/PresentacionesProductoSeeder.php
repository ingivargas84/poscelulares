<?php

use App\PresentacionProducto;
use Illuminate\Database\Seeder;

class PresentacionesProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $pp = new PresentacionProducto();
        $pp->presentacion = 'Telefonos';
        $pp->save();

        $pp = new PresentacionProducto();
        $pp->presentacion = 'Recargas';
        $pp->save();

        $pp = new PresentacionProducto();
        $pp->presentacion = 'Accesorios';
        $pp->save();

        $pp = new PresentacionProducto();
        $pp->presentacion = 'Herramientas';
        $pp->save();

        $pp = new PresentacionProducto();
        $pp->presentacion = 'MicroSD';
        $pp->save();

        $pp = new PresentacionProducto();
        $pp->presentacion = 'Tabletas';
        $pp->save();
        
    }
}
