<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Venta;
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
            'is_proveedor'=>'nullable|boolean',
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
        $client_back->load('descuentos.producto');
    
        $ventas = Venta::where('cliente_id', $client_back->id)->latest()->paginate(5);

        $vendido_ultimo_mes = Venta::where('cliente_id', $client_back->id)
            ->whereBetween('created_at', [
                now()->startOfMonth(), 
                now()->endOfMonth() 
            ])->sum('total');
        $ventas_pendientes = $client_back->ventas;
        $total_pendiente = $ventas_pendientes->filter(
            function($venta) {
                return $venta->pagado === false;
            }
        )->sum('total');

        return response()->json([
            'data' => $client_back,
            'ventas' => $ventas,
            'vendido_ultimo_mes' => $vendido_ultimo_mes,
            'pendientes' => $ventas_pendientes,
            'total_pendiente' => $total_pendiente
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Clientes $client_back, Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|digits:10|integer',
            'is_proveedor'=>'nullable|boolean',
            'direccion' => 'nullable|string',
            'credito' => 'boolean',
            'monto' => 'numeric|min:0',
        ]);

        // return response()->json(['data'=>$request]);
        $cliente = $client_back;
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
