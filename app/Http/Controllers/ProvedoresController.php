<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProvedoresController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data'=>'ndhbd']);
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
        'empresa' => 'required|string|max:255',
        'nombre' => 'required|string|max:255',
        'telefono' => 'required|string|max:20|unique:proveedors,telefono',
        'categoria' => 'required|string|max:255',
    ]);

    $proveedor = Proveedor::create($request->all());

    return response()->json([
        'data' => $proveedor
    ]); 
}

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'empresa' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20|unique:proveedors,telefono',
            'categoria' => 'nullable|string|max:255',
        ]);

        $proveedor->update($request->all());

        // return response()->json(['data'=>$proveedor]);
        return response()->json(['dayta'=>'hnshw']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
