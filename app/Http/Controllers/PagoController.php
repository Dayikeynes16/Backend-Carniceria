<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;

class PagoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function show($id)
    {
        $pago = Venta::with('pago')->find($id);
        return response()->json(['data'=>$pago]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'metodo_de_pago' => 'nullable|string',
            'tarjeta' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'transferencia' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',  
            'efectivo' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/', 
        ]);
    
        $venta = Venta::with('pago')->find($id);
        $pago = $venta->pago;
    
        $totalPagado = ($request->input('tarjeta') ?? 0) + 
                       ($request->input('transferencia') ?? 0) + 
                       ($request->input('efectivo') ?? 0);
    
        $pago->pendiente -= $totalPagado;
    
        if ($pago->pendiente <= 0) {
            $venta->pagado = true;
            $pago->pendiente = 0; 
        }
    
        $pago->tarjeta += $request->input('tarjeta', 0);  
        $pago->transferencia += $request->input('transferencia', 0);
        $pago->efectivo += $request->input('efectivo', 0);
        
        $venta->save();
        $pago->save();
    
        return response()->json(['data' => $venta]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
        //
    }
}
