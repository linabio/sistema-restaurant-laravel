<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEmpleadoSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipos_empleado')->insert([
            [
                'idTipoEmpleado' => 'ADM',
                'nombreTipoEmpleado' => 'Administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idTipoEmpleado' => 'SUP',
                'nombreTipoEmpleado' => 'Supervisor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idTipoEmpleado' => 'EMP',
                'nombreTipoEmpleado' => 'Empleado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
