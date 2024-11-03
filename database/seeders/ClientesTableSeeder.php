<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesTableSeeder extends Seeder
{
    public function run()
    {
        // Array de datos de ejemplo
        $clientes = [
            [
                'id' => 'C001',
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'C002',
                'nombre' => 'Ana',
                'apellido' => 'Gómez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'C003',
                'nombre' => 'Luis',
                'apellido' => 'Martínez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más clientes según sea necesario
        ];

        // Insertar datos en la tabla 'clientes'
        DB::table('clientes')->insert($clientes);
    }
}
