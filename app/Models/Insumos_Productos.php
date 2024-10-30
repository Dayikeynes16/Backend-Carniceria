<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumos_Productos extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','peso','insumo_id','producto_id'];

    public function producto () {
        return $this->belongsTo(Producto::class);
    }

    public function insumo(){
        return $this->belongsTo(Insumo::class);
    }
}
