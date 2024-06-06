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



Route::group(['middleware'=>['auth']],function(){
    route::post('/guardarDireccion', [ProductsController::class,'guardarDireccion']);
    route::post('/eliminarDireccion',[ProductsController::class,'eliminarDireccion']);
    route::post('/eliminarProducto', [ProductsController::class, 'eliminarProducto']);
    route::get('/get_user', [AuthController::class, 'get_user']);
    route::post('/deletefile', [QuoteController::class, 'deletefile']);
    route::post('/calculate', [QuoteController::class, 'calculate']);
    route::get('/getDirecciones', [ProductsController::class, 'getDirecciones']);
    route::get('/traerarchivos', [ModelsController::class, 'traerarchivos']);
    route::get('/modelos', [ProductsController::class, 'Modelos']);
    route::post('/savemodel', [ProductsController::class, 'StoreProduct']);
    Route::get('/productos/{producto}',[ModelsController::class,'show']);
    Route::post('/productos/{producto}',[ModelsController::class,'update']);

});

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

route::get('/products/{product}/image', [ProductsController::class, 'image'])->name('products.image');
route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');

