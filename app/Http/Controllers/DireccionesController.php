<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionesController extends Controller
{
    //
    public function guardarDireccion(Request $request)
{
    $validatedData = $request->validate([
        'destinatario' => 'required|string',
        'telefono' => 'required|string',
        'direccion' => 'required|string',
        'referencias' => 'required|string'
    ]);

    $direccion = Direccion::create([
        'usuario_id' => $request->user()->id,
        'direccion' => $request->input('direccion'),
        'telefono' => $request->input('telefono'),
        'referencias' => $request->input('referencias'),
        'destinatario' => $request->input('destinatario')
    ]);

    return response()->json(['data' => $direccion], 201);
}


    function getDirecciones(Request $request){
        $direcciones = Direccion::where('usuario_id',$request->user()->id)->get();
        return response()->json($direcciones);
    }

    function eliminarDireccion(Request $request){
        $direccion = Direccion::find($request->input('id'));
        $direccion->delete();
        return response()->json(['data'=>200]);
    }
}
