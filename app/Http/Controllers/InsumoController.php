<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;

class InsumoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data'=> Insumo::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255|unique:insumos,nombre',
            'peso' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
    
        $insumo = Insumo::create([
            'nombre' => $request->input('nombre'),
            'peso' => $request->input('peso'),
            'precio' => $request->input('precio'),
            'total' => $request->input('precio') * $request->input('peso'),
            'proveedor_id' => $request->input('proveedor_id'),  // Corrección aquí
            'categoria_id' => $request->input('categoria_id'),  // Y corrección aquí
        ]);
    
        return response()->json(['data' => $insumo]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Insumo $insumo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insumo $insumo)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255|unique:insumos,nombre',
            'peso' => 'nullable|numeric|min:0',
            'precio' => 'nullable|numeric|min:0',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $insumo->update($request->all());

        return response()->json(['data'=>$insumo]);

    }     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insumo $insumo)
    {
        //
    }
}
