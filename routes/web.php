<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

route::controller(QuoteController::class)->group(function () {
    // route::get('/', 'testing')->name('testing');
    route::post('/calculate', 'calculate')->name('calculate');
});

route::get('/fecha', function () {
    return response()->json(['data' => now()->toDateString()]);
});
route::get('/usuarios3', [AuthController::class, 'verusuarios']);

route::post('/login', [AuthController::class, 'login']);


route::post('/cumple', function (Request $request) {
    $request->validate([
        'fecha'=>'required|date',
        'nombre' => 'required'
    ]);

    $edad = Carbon::parse($request->fecha)->age;
    return response()->json([
        'data' => "Hola {$request->nombre}. Tienes {$edad} años.",
    ]);
});
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

route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '.*');

