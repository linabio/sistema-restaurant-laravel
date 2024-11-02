<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->string('id', 8)->primary();
            $table->string('id_tipo_empleado', 8);
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('imagen', 50);
            $table->integer('estado');
            $table->date('fecha_registro');
            $table->date('fecha_edicion');
            $table->timestamps();

            $table->foreign('id_tipo_empleado')
                  ->references('idTipoEmpleado')
                  ->on('tipos_empleado')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
