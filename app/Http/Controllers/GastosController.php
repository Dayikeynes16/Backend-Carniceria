<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\Console\Input\Input;

class GastosController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();
        $gastos = Gasto::whereDate('created_at', $today)->latest()->get();
        return response()->json([
            'data' => $gastos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad' => 'required|numeric',
            'categoria' => 'required|string',
            'pagado_caja' =>  'required|boolean'
        ]);

        $gasto = Gasto::create([
            'total' => $request->Input('cantidad'),
            'pagado_caja' => $request->input('categoria'),
            'descripcion' => $request->input('descripcion'),
            'nombre' => $request->input('nombre'),
            'categoria' => $request->input('categoria')

        ]);
        
        return $gasto;
    }

    /**
     * Display the specified resource.
     */
    public function show(Gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gasto $gasto)
    {
        //
    }
}
