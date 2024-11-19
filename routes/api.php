<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DetallePagoController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PrecioEspecialController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProductoVentaController;
use App\Http\Controllers\ProvedoresController;
use App\Http\Controllers\VentaClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VentaDiariaController;
use App\Models\Precio_especial;
use Psr\Http\Client\ClientInterface;

Route::apiResource('/producto', ProductosController::class);
Route::apiResource('/venta', VentaController::class);
Route::apiResource('/producto-venta', ProductoVentaController::class);
Route::apiResource('/corte-caja', VentaDiariaController::class);
Route::apiResource('/gastos-back', GastosController::class);
Route::apiResource('/client-back', ClientesController::class);
Route::apiResource('/pagos-back', PagoController::class);
Route::apiResource('/precio-especial', PrecioEspecialController::class);
Route::apiResource('/insumos', InsumoController::class);
Route::apiResource('/proveedores', ProvedoresController::class);
Route::apiResource('/categorias', CategoriaController::class);
Route::apiResource('/detalle_pago', DetallePagoController::class);
Route::apiResource('/descuento', VentaClienteController::class);



// Route::get('/{any}', function (): View {
//     return view('welcome');
// })->where('any', '.*');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
