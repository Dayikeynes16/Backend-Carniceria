<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['total','metodo_de_pago','pagado','balanza'];

    public function productos(){
        return $this->hasMany( ProductoVenta::class);
    }
}
