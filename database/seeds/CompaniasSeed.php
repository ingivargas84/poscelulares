<?php

use Illuminate\Database\Seeder;
use App\Compania;

class CompaniasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = new Compania();
        $c->compania = "Tigo";
        $c->save();

        $c = new Compania();
        $c->compania = "Claro";
        $c->save();
    }
}
