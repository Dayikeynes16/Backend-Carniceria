<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Orden;
use App\Models\Product;
use Illuminate\Http\Request;

class ModelsController extends Controller
{

    function traerarchivos(Request $request)
    {
        $ordenes = Orden::with('files')->where('usuario_id', $request->user()->id)
            ->where('status', 'activo')->first();
        // $files = Files::query()->where('orden_id', $ordenes->id)->get();

        return response()->json(['data' => $ordenes]);
    }


}
