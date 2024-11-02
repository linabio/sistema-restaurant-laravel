<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'total',
        'mesa_id',
    ];

    // Relación con la tabla Mesa (una Boleta pertenece a una Mesa)
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
