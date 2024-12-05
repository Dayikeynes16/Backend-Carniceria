<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'precio_de_venta','piezas', 'precio_produccion', 'imagen','for_public'];

    protected $table = 'productos';

    protected $casts = [
        'precio_de_venta' => 'float',
        'precio_produccion' => 'float',
    ];
}