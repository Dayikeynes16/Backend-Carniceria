<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio_especial extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id','cliente_id','precio'];

    public function cliente(){
        return $this->belongsTo(Venta::class);
    }
    
    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}

