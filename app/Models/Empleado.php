<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_tipo_empleado',
        'nombre',
        'apellido',
        'imagen',
        'estado',
        'fecha_registro',
        'fecha_edicion'
    ];

    public function tipoEmpleado()
    {
        return $this->belongsTo(TipoEmpleado::class, 'id_tipo_empleado', 'idTipoEmpleado');
    }

    public function usuario()
    {
        return $this->morphOne(Usuario::class, 'userable');
    }
}