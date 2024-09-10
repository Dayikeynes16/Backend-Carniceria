<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => Producto::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'precio_de_venta' => 'required|numeric',
            'precio_produccion' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        $imagePath = $request->file('imagen')->store('productos', 'public');
        Producto::create([
            'nombre' => $request->nombre,
            'precio_de_venta' => $request->precio_de_venta,
            'precio_produccion' => $request->precio_produccion,
            'imagen' => $imagePath,
        ]);
        
        return response()->json(['data'=>'exito']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
