<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    function StoreProduct(Request $request){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image'=> 'required|mimes:jpeg,jpg,png,gif',
            'price' => 'required'
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = 'images/'.$imageName;
        $product->price = $request->price;
        $product->save();
        return response()->json(['data'=>$product]);
    }

    function Modelos(Request $request){
        return Product::paginate(3);

    }
}
