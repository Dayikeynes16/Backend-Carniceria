<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Product;
use App\Models\Producto_Carrito;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    //
    public function añadirCarrito(Request $request){
        

        $producto = Product::find($request->input('id'));
        // return response($producto);
        
        $carrito = Carrito::firstorCreate([
            'status' => 'activo',
            'usuario_id' => $request->user()->id
        ],[
             'total' => 0,
                'status'=> 'activo',
                'direccion_id'=> null
        ]);

        $productoCarrito = Producto_Carrito::create([
            'producto_id'=>$producto->id,
            'carrito_id'=>$carrito->id,
            'total'=>$producto->price
        ]);
        $productoCarrito->save();

        $carrito->total = $producto->price;
        $carrito->save();
        return response($carrito);
    }




    public function traerCarrito(Request $request){

        $user = $request->user()->id;
        $carrito = Carrito::with('productosCarritos')->where('usuario_id',$user)->first();
        return response($carrito);
    }
}
