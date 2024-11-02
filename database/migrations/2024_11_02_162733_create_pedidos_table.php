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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->integer('estado');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            // Ajustar el tipo de dato de cliente_id
            $table->string('cliente_id', 10)->index();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('cascade')->onDelete('cascade');
            
            // Ajustar el tipo de dato de empleado_id
            $table->string('empleado_id', 8)->index();
            $table->foreign('empleado_id')->references('id')->on('empleados')->onUpdate('cascade')->onDelete('cascade');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};