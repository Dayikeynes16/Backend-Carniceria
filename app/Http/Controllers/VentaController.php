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
        // $ventas = Venta::with('productos.producto','pago')->where('pagado', false)->where('estatus', 'activo')->get();
        $ventas = Venta::with('productos.producto','pago')->get();
        return response()->json(['data' => $ventas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'balanza' => 'required|integer',
            'productos' => 'required|array',
            'estatus' => 'required|string',
        ]);

        $productos = $request->input('productos');
        $venta = Venta::Create([
            'total' => 0,
            'pagado' => false,
            'metodo_de_pago' => 'efectivo',
            'balanza' => $request->input('balanza'),
            'estatus' => $request->input('estatus'),
        ]);
        $total = 0;
        foreach ($productos as $producto) {
            $productoOriginal = Producto::find($producto['id']);

            $productoVenta = ProductoVenta::create([
                'producto_id' => $productoOriginal->id,
                'venta_id' => $venta->id,
                'precio' => $productoOriginal->precio_de_venta,
                'peso' => $producto['peso'],
                'total' => $producto['peso'] * $productoOriginal->precio_de_venta,
                
            ]);
            $total += $productoVenta->total;

        }
        $venta->total = $total;
        $venta->save();
        $venta->load('cliente');
        $pago = Pago::create([
            'total' => $total,
            'pendiente' => $total,
            'venta_id' => $venta->id,
            'metodo' => ''
        ]);
        $pago->save();
        $venta->load('pago');

        return response()->json(['data' => $venta]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $ventum)
    {
        $ventum->load('productos.producto','pago.detalles');
        $clientes = Clientes::with('descuentos')->where('is_proveedor',false)->get();
        
    
        return response()->json(['data' => $ventum, 'clientes'=>$clientes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Venta $ventum, Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
        ]);
    
        $venta = $ventum;
        $venta->cliente_id = $validatedData['cliente_id'];
    
        $cliente = Clientes::with('descuentos')->find($validatedData['cliente_id']);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    
        $descuentos = $cliente->descuentos;
    
        // Obtener todos los productos de la venta
        $productos = ProductoVenta::where('venta_id', $venta->id)->get();
    
        if ($productos->isEmpty()) {
            $venta->load('pago', 'cliente', 'productos.producto');
            return response()->json(['data' => $venta]);
        }
    
        // Calcular el total considerando productos con y sin descuento
        $total = 0;
    
        foreach ($productos as $producto) {
            // Verificar si el producto tiene descuento
            $descuento = $descuentos->firstWhere('producto_id', $producto->producto_id);
    
            if ($descuento) {
                // Aplicar descuento si existe
                $producto->precio = $descuento->precio;
                $producto->total = $descuento->precio * $producto->peso;
            } else {
                // Usar el precio normal si no tiene descuento
                $producto->total = $producto->precio * $producto->peso;
            }
    
            // Guardar los cambios en el producto
            $producto->save();
    
            // Sumar al total de la venta
            $total += $producto->total;
        }
    
        // Actualizar el total de la venta
        $venta->update(['total' => $total]);
    
        // Actualizar el total del pago si existe
        if ($venta->pago) {
            $pago = $venta->pago;
            $pago->total = $venta->total;
            $pago->save();
        }
    
        // Cargar todas las relaciones necesarias
        $venta->load('pago', 'cliente', 'productos.producto');
    
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


    public function create_pago() {
        
    }

    public function pendiente(){
        
        $ventas = Venta::with('productos.producto', 'pago')->where('pagado', false)->where('estatus', 'en proceso')->get();
        return response()->json(['data' => $ventas]);
    }
}
