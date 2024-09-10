<?php

namespace App\Http\Controllers;

use App\Models\VentaDiaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaDiariaController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ventas = VentaDiaria::latest()->get();
        return response()->json(['data' => $ventas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subtotal_efectivo' => 'required|numeric',
            'subtotal_tarjeta' => 'required|numeric',
            'subtotal_transferencia' => 'required|numeric'
        ]);

        $ventaDiaria = VentaDiaria::create([
            'subtotal_efectivo' => $request->input('subtotal_efectivo'),
            'subtotal_tarjeta' => $request->input('subtotal_tarjeta'),
            'subtotal_transferencia' => $request->input('subtotal_transferencia'),
            'total' => (
                $request->input('subtotal_efectivo') + $request->input('subtotal_tarjeta') +$request->input('subtotal_transferencia')
            )
        ]);

        return response()->json(['data' => $ventaDiaria]);
    }

    /**
     * Display the specified resource.
     */
    public function show(VentaDiaria $ventaDiaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VentaDiaria $ventaDiaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VentaDiaria $ventaDiaria)
    {
        //
    }
}
