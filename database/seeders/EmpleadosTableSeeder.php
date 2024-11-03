<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('empleados')->insert([
            [
                'id' => 'EMP001',
                'id_tipo_empleado' => 'ADM',
                'nombre' => 'Carlos',
                'apellido' => 'Pérez',
                'imagen' => 'carlos_perez.jpg',
                'estado' => 1,
                'fecha_registro' => now(),
                'fecha_edicion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'EMP002',
                'id_tipo_empleado' => 'SUP',
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'imagen' => 'ana_martinez.jpg',
                'estado' => 1,
                'fecha_registro' => now(),
                'fecha_edicion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'EMP003',
                'id_tipo_empleado' => 'EMP',
                'nombre' => 'Luis',
                'apellido' => 'Gómez',
                'imagen' => 'luis_gomez.jpg',
                'estado' => 1,
                'fecha_registro' => now(),
                'fecha_edicion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
