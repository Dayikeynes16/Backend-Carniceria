<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\PagoController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProductoVentaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VentaDiariaController;
use Psr\Http\Client\ClientInterface;

Route::apiResource('/producto', ProductosController::class);
Route::apiResource('/venta', VentaController::class);
Route::apiResource('/producto-venta', ProductoVentaController::class);
Route::apiResource('/corte-caja', VentaDiariaController::class);
Route::apiResource('/gastos-back', GastosController::class);
Route::apiResource('/client-back', ClientesController::class);
Route::apiResource('/pagos-back', PagoController::class);


Route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');
