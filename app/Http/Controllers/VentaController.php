<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Pago;
use App\Models\Precio_especial;
use App\Models\Producto;
use App\Models\ProductoVenta;
use App\Models\Venta;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VentaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('productos.producto','pago')->where('pagado', false)->get();
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
        $pago = Pago::create([
            'total' => $total,
            'tarjeta' => 0,
            'efectivo' => 0,
            'transferencia' => 0,
            'status' => '0',
            'pendiente' => $total,
            'venta_id' => $venta->id
        ]);

        return response()->json(['data' => $venta]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $ventum)
    {
        $ventum->load('productos.producto');
    
        return response()->json(['data' => $ventum]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $venta = Venta::with('productos')->find($id);
        
        $venta->cliente_id = $request->input('cliente_id');
        $cliente = Clientes::with('descuentos')->find($request->input('cliente_id'));
    
        $descuentos = $cliente->descuentos;
        
        $descuento_id = $descuentos->pluck('producto_id')->toArray();
        
        $productos = ProductoVenta::where('venta_id', $id)
                                   ->whereIn('producto_id', $descuento_id)
                                   ->get();
        
        foreach ($productos as $producto) {
            $descuento = $descuentos->firstWhere('producto_id', $producto->producto_id);
            
            if ($descuento) {
                $producto->total = $descuento->precio * $producto->peso;
                $producto->precio = $descuento->precio;
                $producto->save(); 
            }
        }
    
        $venta->save();
    
        $venta->load('productos');
    
        return response()->json(['data' => $venta]);
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
