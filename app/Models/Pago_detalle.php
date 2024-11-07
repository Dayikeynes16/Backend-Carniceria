<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'detalles_pagos';

    // Definir los atributos que pueden ser asignados masivamente
    protected $fillable = [
        'pago_id',
        'monto',
        'metodo_de_pago',
        'fecha',
        'referencia',
    ];

    // Definir los casts para los atributos
    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'datetime',
    ];

    // Relación con el modelo Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}