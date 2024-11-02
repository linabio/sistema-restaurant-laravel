<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mesas')->insert([
            [
                'numero' => 1,
                'numero_de_sillas' => 4,
                'is_large' => false,
                'is_occupied' => false,
                'lista_de_pedidos' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero' => 2,
                'numero_de_sillas' => 6,
                'is_large' => true,
                'is_occupied' => false,
                'lista_de_pedidos' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero' => 3,
                'numero_de_sillas' => 2,
                'is_large' => false,
                'is_occupied' => true,
                'lista_de_pedidos' => json_encode(['pedido1', 'pedido2']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries as needed
        ]);
    }
}
