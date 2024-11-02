<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {

        $admin = new Usuario();
        $admin->nombre = 'Admin';
        $admin->email = 'admin@prueba.com';
        $admin->password = '12345678';
        $admin->userable_id = 1;
        $admin->userable_type = 'App\Models\Usuario';
        $admin->save();
    }
}