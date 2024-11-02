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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('descripcion', 255);
            $table->decimal('precio_unitario', 10, 2);
            $table->tinyInteger('stock')->unsigned()->default(0);
            $table->timestamps();
        
            $table->smallInteger('marca_id')->unsigned()->index();
            $table->foreign('marca_id')->references('id')->on('marcas')->onUpdate('cascade')->onDelete('cascade');
            
            $table->smallInteger('tipo_producto_id')->unsigned()->index();
            $table->foreign('tipo_producto_id')->references('id')->on('tipos_producto')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
