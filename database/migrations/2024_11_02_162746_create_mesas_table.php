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
            $table->integer('numero');
            $table->integer('capacidad');
            $table->integer('estado');
            $table->timestamps();

            $table->unsignedSmallInteger('pedido_id')->index();
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onUpdate('cascade')->onDelete('cascade');
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
