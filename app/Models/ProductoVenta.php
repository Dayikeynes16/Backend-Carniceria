<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
    use HasFactory;
    protected $fillable = [
        'venta_id', 
        'producto_id',
        'peso', 
        'total', 
        'precio'
    ];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
