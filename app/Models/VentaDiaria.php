<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDiaria extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'subtotal_transferencia','subtotal_tarjeta','subtotal_efectivo' ];
}
