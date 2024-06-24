<?php


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

use App\Http\Controllers\AuthController;


Route::get('/formulario-recuperar-contrasenia', [AuthController::class, 'formularioRecuperarContrasenia'])->name('formulario-recuperar-contrasenia');
Route::post('/enviar-recuperar-contrasenia', [AuthController::class, 'enviarRecuperarContraseña'])->name('enviar-recuperacion');
Route::get('/reiniciar-contrasenia/{token}', [AuthController::class, 'formularioActualizacion'])->name('formulario-actualizar-contrasenia');
Route::post('/actualizar-contrasenia', [AuthController::class, 'actualizarContrasenia'])->name('actualizar-contrasenia');


use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('recipient@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent';
});


Route::group(['middleware' => ['auth']], function(){
    Route::post('/guardarDireccion', [DireccionesController::class, 'guardarDireccion']);
    Route::post('/eliminarDireccion', [DireccionesController::class, 'eliminarDireccion']);
    Route::post('/eliminarProducto', [ProductosController::class, 'eliminarProducto']);
    Route::get('/get_user', [AuthController::class, 'get_user']);
    Route::post('/deletefile', [ArchivosController::class, 'deletefile']);
    Route::post('/calculate', [ArchivosController::class, 'calculate']);
    Route::get('/getDirecciones', [DireccionesController::class, 'getDirecciones']);
    Route::get('/traerarchivos', [ModelsController::class, 'traerarchivos']);
    Route::get('/modelos', [ProductosController::class, 'traerProductos']);
    Route::post('/savemodel', [ProductosController::class, 'StoreProduct']);
    Route::get('/productos/{producto}', [ProductosController::class, 'show']);
    Route::post('/productos/{producto}', [ProductosController::class, 'update']);
    Route::post('/guardarImagen', [ImagenesController::class, 'guardarImagen']);
    Route::get('/getImagenes', [ImagenesController::class, 'getImagenes']);
    Route::post('/eliminarImagen', [ImagenesController::class, 'eliminarImagen']);
    Route::post('/añadirCarrito', [CarritoController::class, 'añadirCarrito']);
    Route::post('/cerrarSesion', [AuthController::class, 'cerrarSesion']);
    Route::get('/traerCarrito', [CarritoController::class, 'traerCarrito']);
    Route::post('/borrarProducto', [CarritoController::class, 'borrarProducto']);
    Route::post('/actualizarProductoCarrito', [CarritoController::class, 'actualizar']);
    Route::post('/añadirStlCarrito', [CarritoController::class, 'añadirStlCarrito']);
    Route::post('/actualizarFileCarrito', [CarritoController::class, 'actualizarFileCarrito']);
    Route::post('/finalizarCarrito',[CarritoController::class, 'finalizarCarrito']);


    Route::get('/getCarritosPendientes', [CarritoController::class, 'getCarritosPendientes']);
    Route::get('/carrito/{carrito}',[CarritoController::class, 'show']);
});

Route::get('/auth', [AuthController::class, 'auth']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/usuarios', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed'
    ]);

    $usuario = User::create($request->all());
    return response()->json([
        'data' => $usuario, 'message' => 'Usuario guardado con éxito'
    ], 200);
});

Route::get('/images/{image}/image', [ImagenesController::class, 'showImage'])->name('images.image');
Route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');
