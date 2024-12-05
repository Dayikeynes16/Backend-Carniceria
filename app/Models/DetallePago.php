<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table = 'detalles_pagos';

    protected $fillable = [
        'pago_id',
        'monto',
        'metodo_de_pago',
        'referencia',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}