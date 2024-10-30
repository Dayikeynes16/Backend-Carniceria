<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = ['total','metodo_de_pago','tarjeta', 'transferencia','efectivo','pendiente','venta_id'];

    public function venta() {
        return $this->belongsTo(Venta::class);
    }



}
