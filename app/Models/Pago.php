<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'venta_id','pendiente'];

    public function venta() {
        return $this->belongsTo(Venta::class);
    }

    public function pagos(){
        return $this->hasMany(DetallePago::class,'pago_id');
    }



}
