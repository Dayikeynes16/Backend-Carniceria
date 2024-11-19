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
        'proveedor',
        'is_proveedor'
    ];

    public function ventas() {
        return $this->hasMany(Venta::class, 'cliente_id'); // Cambia 'cliente_id' si es necesario
    }
    public function descuentos(){
        return $this->hasMany(Precio_especial::class, 'cliente_id');

    }
}
