<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    function StoreProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'price' => 'required'
        ]);

        $product = Product::create(
            array_merge($request->all(), [
                'image' => $request->file('image')->store('images')
            ])
        );
        return response()->json(['data' => $product, 'code'=>200]);
    }

    function Modelos(Request $request)
    {
        return Product::paginate(3);
    }
    function image(Product $product){
        return Storage::response($product->image);

    }

    function eliminarProducto(Request $request){
        $id = $request->input('id');
        $producto = Product::find($id);
        $producto->delete();
        return response(['data'=> 200, 'message'=>'producto eliminado con exito']);

    }

    function guardarDireccion(Request $request){
        $request->validate([
            'destinatario' => 'required|string',
            'telefono' => 'required|string',
            'direccion'=> 'required|string',
            'referencias'=>'required|string'
        ]);

        $direccion = Direccion::create([
            'usuario_id'=>$request->user()->id,
            'direccion'=>$request->input('direccion'),
            'telefono'=>$request->input('telefono'),
            'referencias'=>$request->input('referencias'),
            'destinatario'=>$request->input('destinatario')

        ]);
        $direccion->create();

        return response($direccion);
        
    }

    function getDirecciones(Request $request){
        $direcciones = Direccion::where('usuario_id',$request->user()->id)->get();
        return response()->json($direcciones);
    }

    function eliminarDireccion(Request $request){
        $direccion = Direccion::find($request->input('id'));
        $direccion->delete();
        return response()->json(['data'=>200]);
    }
}
