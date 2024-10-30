<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'cordenadas',
        'credito',
        'monto',
        'proveedor'
    ];

    public function ventas () {
        return $this->hasMany(Venta::class);
    }
    public function descuentos(){
        return $this->hasMany(Precio_especial::class,'cliente_id');

    }
}
