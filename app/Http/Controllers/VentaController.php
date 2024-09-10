<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoVenta;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('productos.producto')->where('pagado', false)->get();
        return response()->json(['data' => $ventas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'balanza' => 'required|integer',
            'productos' => 'required|array'
        ]);

        $productos = $request->input('productos');
        $venta = Venta::Create([
            'total' => 0,
            'pagado' => false,
            'metodo_de_pago' => 'efectivo',
            'balanza' => $request->input('balanza')
        ]);
        $total = 0;
        foreach ($productos as $producto) {
            $productoOriginal = Producto::find($producto['producto_id']);
            $productoVenta = ProductoVenta::create([
                'producto_id' => $productoOriginal->id,
                'venta_id' => $venta->id,
                'precio' => $productoOriginal->precio_de_venta,
                'peso' => $producto['peso'],
                'total' => $producto['peso'] * $productoOriginal->precio_de_venta
            ]);
            $total += $productoVenta->total;

        }
        $venta->total = $total;
        $venta->save();

        return response()->json(['data' => $venta]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $ventum, Request $request)
    {
        $ventum->delete();

        return $ventum;
    }
}
