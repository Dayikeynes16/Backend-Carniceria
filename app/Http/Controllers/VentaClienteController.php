<?php

namespace App\Http\Controllers;

use App\Models\VentaCliente;
use Illuminate\Http\Request;

class VentaClienteController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => VentaCliente::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VentaCliente $ventaCliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VentaCliente $ventaCliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VentaCliente $ventaCliente)
    {
        //
    }
}
