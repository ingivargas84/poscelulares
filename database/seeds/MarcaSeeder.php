<?php

use Illuminate\Database\Seeder;
use App\Marca;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mar = new Marca();
        $mar->marca = 'Samsung';
        $mar->save();

        $mar = new Marca();
        $mar->marca = 'Huawei';
        $mar->save();

        $mar = new Marca();
        $mar->marca = 'Blackberry';
        $mar->save();

        $mar = new Marca();
        $mar->marca = 'Alcatel';
        $mar->save();

        $mar = new Marca();
        $mar->marca = 'AOC';
        $mar->save();

    }
}
