<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\ImagenesController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\CarritoController;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;



Route::group(['middleware'=>['auth']],function(){
    route::post('/guardarDireccion', [DireccionesController::class,'guardarDireccion']);
    route::post('/eliminarDireccion',[DireccionesController::class,'eliminarDireccion']);
    route::post('/eliminarProducto', [ProductosController::class, 'eliminarProducto']);
    route::get('/get_user', [AuthController::class, 'get_user']);
    route::post('/deletefile', [ArchivosController::class, 'deletefile']);
    route::post('/calculate', [ArchivosController::class, 'calculate']);
    route::get('/getDirecciones', [DireccionesController::class, 'getDirecciones']);
    route::get('/traerarchivos', [ModelsController::class, 'traerarchivos']);
    route::get('/modelos', [ProductosController::class, 'traerProductos']);
    route::post('/savemodel', [ProductosController::class, 'StoreProduct']);
    Route::get('/productos/{producto}',[ProductosController::class,'show']);
    Route::post('/productos/{producto}',[ProductosController::class,'update']);
    Route::post('/guardarImagen', [ImagenesController::class, 'guardarImagen']);
    Route::get('/getImagenes',[ImagenesController::class, 'getImagenes']);
    Route::post('/eliminarImagen', [ImagenesController::class, 'eliminarImagen']);
    Route::post('/añadirCarrito',[CarritoController::class,'añadirCarrito']);
    Route::post('/cerrarSesion',[AuthController::class, 'cerrarSesion']);
    Route::get('/traerCarrito',[CarritoController::class,'traerCarrito']);
});

Route::get('/auth',[AuthController::class, 'auth']);
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

route::get('/images/{image}/image', [ImagenesController::class, 'showImage'])->name('images.image');
route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');

