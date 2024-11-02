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
        Schema::create('boletas', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->dateTime('fecha');
            $table->decimal('total', 10, 2);

            $table->smallInteger('mesa_id')->unsigned()->index();
            $table->foreign('mesa_id')->references('id')->on('mesas')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletas');
    }
};
