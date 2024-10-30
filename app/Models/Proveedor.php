<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar de manera masiva
    protected $fillable = [
        'empresa',
        'nombre',
        'telefono',
        'categoria',
    ];

    // Definir los casts para convertir automáticamente los tipos de datos
    protected $casts = [
        'empresa' => 'string',
        'nombre' => 'string',
        'telefono' => 'string',
        'categoria' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}