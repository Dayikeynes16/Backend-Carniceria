<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;
    protected $fillable= ['usuario_id','status','direccion_id','total'];

    public function direccion(){
        return $this->hasOne(Direccion::class,'direccion_id');
    }

    public function productosCarritos(){
        return $this->hasMany(Producto_Carrito::class,'carrito_id');
    }

    public function orden(){
        return $this->hasMany(Orden::class,'carrito_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }
    
}
