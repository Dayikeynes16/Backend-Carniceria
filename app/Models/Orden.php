<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'usuario_id', 'total'];

    protected $table = 'ordenes';

    
    public function files (){
        return $this->hasMany(Files::class, 'orden_id');
    }
    
}
