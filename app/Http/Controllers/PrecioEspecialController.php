<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Precio_especial;
use Illuminate\Http\Request;

class PrecioEspecialController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Clientes::with('descuentos.producto')->get();
        return response()->json(['data' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'precio' => ['required', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        $precio = Precio_especial::create($request->all());
    
        return response()->json(['data' => $precio]);
        }

    /**
     * Display the specified resource.
     */
    public function show(Precio_especial $precio_especial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Precio_especial $precio_especial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Precio_especial $precio_especial)
    {
        //
    }
}
