<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmpleado extends Model
{
    use HasFactory;

    protected $table = "tipos_empleado"; 
    protected $primaryKey = 'idTipoEmpleado'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'idTipoEmpleado', 
        'nombreTipoEmpleado'
    ];
}
