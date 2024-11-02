<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'numero_de_sillas',
        'is_large',
        'is_occupied',
        'lista_de_pedidos'
    ];

    // Configura un mutador para que is_large se actualice automáticamente en función del número de sillas
    public function setNumeroDeSillasAttribute($value)
    {
        $this->attributes['numero_de_sillas'] = $value;
        $this->attributes['is_large'] = $value > 3;
    }
}
