<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mesas', function (Blueprint $table) {
            $table->smallIncrements('id');


            $table->integer('numero')->unique();
            $table->integer('numero_de_sillas'); // Número de sillas
            $table->boolean('is_large')->default(false); // Si la mesa es grande (basado en numero_de_sillas)
            $table->boolean('is_occupied')->default(false); // Estado de ocupación
            $table->string('lista_de_pedidos', 50); // Almacenará la lista de pedidos en formato JSON
           
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
