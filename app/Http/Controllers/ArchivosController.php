<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\Carrito;
use App\Models\Files;
use App\Models\Orden;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ArchivosController extends Controller
{

    public function calculate(request $request)
    {

        $request->validate([
            'file' => 'file|required',

        ]);

        try {
            $response = $this->apiRequest($request->file('file'));

            $orden = Orden::firstOrCreate([
                'status' => 'activo',
                'usuario_id' => $request->user()->id
            ], [
                'total' => 0,
                'status'=> 'activo'
            ]);

            $file = $orden->files()->create([
                'path' => $request->file('file')->store('files'),
                'nombre' => $request->file('file')->getClientOriginalName(),
                'minutos' => ($response['print_time'] / 60) / 3.5,
                'precio' => (($response['print_time'] / 60) / 3.5) * 1.5
                
            ]);
            return response()->json(['data' => $file]);
        } catch (\Exception $e) {
            return response()->json(['message' =>  $e->getMessage()], 409);
        }

        return response()->json(['message' => 'Error al subir el archivo.']);
    }


    public function apiRequest($file)
    {
        $url = "https://stl-info-insight.p.rapidapi.com/3dslicer-02/calculate_volume";

        $headers = [
            "X-RapidAPI-Key" => "97016016d1msh22a2de77d63209bp14b5e9jsn6a63ea5210dc",
            "X-RapidAPI-Host" => "stl-info-insight.p.rapidapi.com",
        ];

        $response = Http::withHeaders($headers)
            ->timeout(60)
            ->attach(
                'stl_file',
                file_get_contents($file->path()),
                $file->getClientOriginalName(),
                ['Content-Type' => $file->getMimeType()]
            )
            ->post($url, [
                'material_type' => 'ABS'
            ]);
        if (!$response->json('http_code')) throw new Exception('Ocurrió un problema al procesar el archivo');

        return $response->json('result_data');
    }

    public function deletefile(Request $request){
        $id = $request->input('id');
        $file = Files::find($id);
        $carrito = Carrito::where('usuario_id', $request->user()->id)->where('status', 'activo')->first();  

    
        if ($file) {
            Storage::delete($file->path);
      
            $file->delete();
            $this->calcularCarrito($carrito->id);
            return response()->json(['data' => 'eliminado con exito']);
        } else {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    }
    
    public function calcularCarrito($id)
    {
        $carrito = Carrito::with('productosCarritos.producto', 'orden.files')->find($id);

        if ($carrito) {
            $total = 0;

         
            foreach ($carrito->productosCarritos as $item) {
                $total += $item->producto->price * $item->cantidad;
            }



          
            foreach ($carrito->orden as $orden) {
                foreach ($orden->files as $file) {
                    $total += $file->precio;
                }
            }

            $carrito->total = $total;
            $carrito->save();
        }
    }
}
