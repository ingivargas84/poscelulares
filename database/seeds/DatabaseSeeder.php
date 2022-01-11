<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(NegocioSeeder::class);
        $this->call(CompaniasSeed::class);
        $this->call(TiposBodegaSeeder::class);
        $this->call(FormasPagoSeeder::class);
        $this->call(PresentacionesProductoSeeder::class);
        $this->call(EstadosNotaEnvioSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(TiendasSeeder::class);
        $this->call(BodegasSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(UsuarioTiendaSeeder::class);

        //$this->call(TiposLocalidadesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
