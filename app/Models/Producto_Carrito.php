<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_Carrito extends Model
{
    use HasFactory;

    protected $fillable=['cantidad','total','carrito_id','producto_id'];

    public function carrito(){
        return $this->belongsTo(Carrito::class,'carrito_id');
    }

    public function producto(){
        return $this->belongsTo(Product::class,'producto_id');
    }
    protected $table = 'producto_carritos';


}
