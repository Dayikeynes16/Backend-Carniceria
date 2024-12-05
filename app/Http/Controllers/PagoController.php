<?php

namespace App\Http\Controllers;

use App\Models\DetallePago;
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
            'tarjeta' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'transferencia' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'efectivo' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);
    
        $venta = Venta::with('pago')->find($id);
    
        if (!$venta || !$venta->pago) {
            return response()->json(['error' => 'Venta o pago no encontrado'], 404);
        }
    
        $pago = $venta->pago;
    
        $pago->load('detalles');
        $totalPagado = $pago->detalles->sum('monto');
        $montoPendiente = $pago->total - $totalPagado;
    
        foreach (['tarjeta', 'transferencia', 'efectivo'] as $metodo) {
            if ($request->$metodo > 0) {
                $montoAPagar = min($request->$metodo, $montoPendiente);
    
                if ($montoAPagar > 0) {
                    DetallePago::create([
                        'pago_id' => $pago->id,
                        'monto' => $montoAPagar,
                        'metodo_de_pago' => $metodo,
                    ]);
    
                    $montoPendiente -= $montoAPagar;
                }
            }
        }
        $pago->load('detalles');
    
        $totalPagado = $pago->detalles->sum('monto');
        $pago->pendiente = max(0, $pago->total - $totalPagado); 
    
        
        if ($pago->pendiente == 0) {
            $venta->estatus = 'pagado';
            $venta->pagado = true;
        } elseif ($pago->pendiente < $pago->total) {
            $venta->estatus = 'en proceso';
        } else {
            $venta->estatus = 'pendiente';
        }
    
        $pago->save();
        $venta->save();
    
        $venta->load('pago.detalles');
    
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
