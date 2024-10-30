<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['total','pagado','balanza', 'status', 'cliente_id'];

    public function productos(){
        return $this->hasMany( ProductoVenta::class);
    }

    public function pago() {
        return $this->hasOne(Pago::class);
    }
     public function cliente(){
        return $this->hasOne(Clientes::class);
     }
}
