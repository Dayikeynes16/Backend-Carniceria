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
        // return response()->json(['data' => Clientes::create($request->all()) ]); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clientes $clientes)
    {
        //
    }
}
