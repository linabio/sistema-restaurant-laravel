<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = "productos";
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_unitario',
        'stock',
        'marca_id',
        'tipo_producto_id'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class);
    }
}