<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaCliente extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'venta_id','pagado'];

    public function cliente(){
        return $this->belongsTo(Clientes::class);
    }
    public function venta(){
        return $this->belongsTo(Venta::class);
    }
}
