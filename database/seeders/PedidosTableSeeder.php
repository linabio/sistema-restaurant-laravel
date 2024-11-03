<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ejemplo de datos que podrías querer insertar
        $pedidos = [
            [
                'estado' => 1,
                'total' => 100.00,
                'cliente_id' => 'C001',
                'empleado_id' => 'EMP001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'estado' => 2,
                'total' => 200.50,
                'cliente_id' => 'C002',
                'empleado_id' => 'EMP002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'estado' => 3,
                'total' => 150.75,
                'cliente_id' => 'C003',
                'empleado_id' => 'EMP003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Puedes añadir más registros según sea necesario
        ];

        // Inserta los datos en la tabla 'pedidos'
        DB::table('pedidos')->insert($pedidos);
    }
}
