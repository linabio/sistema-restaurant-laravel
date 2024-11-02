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
        Schema::create('detalles_pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->timestamps();

            // Cambiar producto_id a unsignedInteger para coincidir con id en productos
            $table->unsignedInteger('producto_id')->index();
            $table->foreign('producto_id')->references('id')->on('productos')->onUpdate('cascade')->onDelete('cascade');

            // Cambiar pedido_id a unsignedSmallInteger para coincidir con id en pedidos
            $table->unsignedSmallInteger('pedido_id')->index();
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_pedidos');
    }
};
