<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesa_id',
        'pedido_id',
        'numero',
        'capacidad',
        'estado'
    ];

    // Configura un mutador para que is_large se actualice automáticamente en función del número de sillas
    public function tipoEmpleado()
    {
        return $this->belongsTo(TipoEmpleado::class, 'pedido_id', 'id');
    }
}
