<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => Clientes::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|digits:10|integer',
            'direccion' => 'nullable|string',
            'credito' => 'boolean',
            'monto' => 'numeric|min:0',
        ]);

        $cliente = Clientes::create($request->all());

        return response()->json(['data'=>$cliente]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $client_back)
    {
        // $cliente = Clientes::find($id);
        
        return response()->json(['data'=>$client_back]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $cliente = Clientes::find($id);
        $cliente->update($request->all());
        return response()->json(['data' => $cliente]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clientes $clientes)
    {
        //
    }
}
