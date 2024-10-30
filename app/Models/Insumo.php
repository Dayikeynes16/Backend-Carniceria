<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'peso',
        'precio',
        'total',
        'proveedor_id',
        'categoria_id'
    ];

    protected $casts = [
        'peso' => 'decimal:2',
        'precio' => 'decimal:2',
        'total' => 'decimal:2',
        'proveedor_id' => 'integer',
        'categoria_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}