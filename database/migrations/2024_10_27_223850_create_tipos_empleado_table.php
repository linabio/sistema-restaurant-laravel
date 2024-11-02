<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposEmpleadoTable extends Migration
{
    public function up()
    {
        Schema::create('tipos_empleado', function (Blueprint $table) {
            $table->string('idTipoEmpleado', 8)->primary();
            $table->string('nombreTipoEmpleado', 50);
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_empleado');
    }
}

