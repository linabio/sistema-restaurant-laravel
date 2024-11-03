<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos para insertar
        $mesas = [
            ['numero' => 1, 'capacidad' => 2, 'estado' => 1, 'pedido_id' => 1],
            ['numero' => 2, 'capacidad' => 4, 'estado' => 1, 'pedido_id' => 2],
            ['numero' => 3, 'capacidad' => 6, 'estado' => 0, 'pedido_id' => 3]
        ];

        // Insertar los datos en la tabla 'mesas'
        DB::table('mesas')->insert($mesas);
    }
}
