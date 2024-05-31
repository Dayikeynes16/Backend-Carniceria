<?php

namespace App\Http\Controllers;

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
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'price' => 'required'
        ]);

        $product = Product::create(
            array_merge($request->all(), [
                'image' => $request->file('image')->store('images')
            ])
        );
        return response()->json(['data' => $product]);
    }

    function Modelos(Request $request)
    {
        return Product::paginate(10);
    }
    function image(Product $product){
        return Storage::response($product->image);

    }
}
