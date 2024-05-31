<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\QuoteController;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;


route::post('/calculate', [QuoteController::class, 'calculate'])->middleware('auth');

route::get('/traerarchivos', [ModelsController::class, 'traerarchivos'])->middleware('auth');




route::post('/login', [AuthController::class, 'login']);


route::post('/usuarios', function (Request $request) {
    $request->validate([
        'name'=>'required',
        'email' => 'required|email|unique:users,email',
        'password'=> 'required|confirmed'
    ]);

    $usuario = User::create($request->all());
    return response()->json([
        'data' => $usuario,'usuuario guardado con exito'
    ],200);
});
route::get('/modelos', [ProductsController::class, 'Modelos']);
route::post('/savemodel', [ProductsController::class, 'StoreProduct']);
route::post('/products', [ProductsController::class, 'StoreProduct']);
route::get('/products/{product}/image', [ProductsController::class, 'image'])->name('products.image');
route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');

