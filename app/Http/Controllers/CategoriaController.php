<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(['data'=>Categoria::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255|unique:categorias,nombre',
    ]);

        $categoria = Categoria::create($request->all());

        return response()->json([
            'data' => $categoria
        ], 201); 
 
}

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return response()->json(['data'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);
        $categoria->update($request->all());
        
        return response()->json([
            'data' => $categoria
        ]); 
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return response()->json(['data'=>$categoria]);
        
    }
}
