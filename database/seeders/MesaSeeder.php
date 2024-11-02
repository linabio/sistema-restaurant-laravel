<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        [
            'numero' => 1,
            'capacidad' => 4,
            'ubicacion' => false,
            'is_occupied' => false,
            'lista_de_pedidos' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        [
            'numero' => 2,
            'numero_de_sillas' => 6,
            'is_large' => true,
            'is_occupied' => false,
            'lista_de_pedidos' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        [
            'numero' => 3,
            'numero_de_sillas' => 2,
            'is_large' => false,
            'is_occupied' => true,
            'lista_de_pedidos' => json_encode(['pedido1', 'pedido2']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        //
    }
}
