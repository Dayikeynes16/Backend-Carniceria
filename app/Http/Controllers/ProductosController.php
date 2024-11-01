<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class ProductosController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => Producto::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         // Validar los datos
         $request->validate([
             'nombre' => 'required|string',
             'precio_de_venta' => 'required|numeric',
             'precio_produccion' => 'required|numeric',
             'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
             'piezas' => 'required|boolean'
         ]);
     
         // Preparar el archivo para subir a Supabase
         $image = $request->file('imagen');
         $imagePath = $image->getPathname(); // Ruta temporal del archivo
         $imageName = $image->getClientOriginalName(); // Nombre del archivo
     
         // Subir la imagen a Supabase
         $client = new Client([
             'base_uri' => env('SUPABASE_URL') . '/storage/v1/', // Ajusta la base_uri
             'headers' => [
                 'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                 'apikey' => env('SUPABASE_API_KEY'),
             ],
         ]);
     
         try {
             // Subir el archivo
             $response = $client->post('object/products/' . $imageName, [
                 'body' => fopen($imagePath, 'r'),
                 'headers' => [
                     'Content-Type' => $image->getMimeType(),
                 ],
             ]);
     
             // Verificar la respuesta del servidor
             if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
                 // Obtener la URL pública de la imagen
                 $imageUrl = env('SUPABASE_URL') . '/storage/v1/object/products/' . $imageName;
     
                 // Guardar el producto en la base de datos
                 Producto::create(
                    
                [
                     'nombre' => $request->nombre,
                     'precio_de_venta' => $request->precio_de_venta,
                     'precio_produccion' => $request->precio_produccion,
                     'imagen' => $imageUrl,
                     'piezas' => $request->piezas
                 ]
                );
     
                 return response()->json(['data' => 'exito']);
             } else {
                 throw new \Exception("Error al subir la imagen, código de estado: " . $response->getStatusCode());
             }
         } catch (\Exception $e) {
             return response()->json(['error' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
         }
     }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return response()->json(['data' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        // // Validar los datos
        // $request->validate([
        //     'nombre' => 'required|string',
        //     'precio_de_venta' => 'required|numeric',
        //     'precio_produccion' => 'required|numeric',
        //     'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif' // Imagen es opcional
        // ]);
    
        $producto = Producto::find($id);

    
        if ($request->hasFile('imagen')) {
            // Subir la nueva imagen
            $image = $request->file('imagen');
            $imagePath = $image->getPathname(); // Ruta temporal del archivo
            $imageName = $image->getClientOriginalName(); // Nombre del archivo
    
            // Preparar el cliente HTTP para Supabase
            $client = new Client([
                'base_uri' => env('SUPABASE_URL') . '/storage/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                    'apikey' => env('SUPABASE_API_KEY'),
                ],
            ]);
    
            try {
                // Subir el archivo a Supabase
                $response = $client->post('object/products/' . $imageName, [
                    'body' => fopen($imagePath, 'r'),
                    'headers' => [
                        'Content-Type' => $image->getMimeType(),
                    ],
                ]);
    
                if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
                    // Obtener la URL pública de la nueva imagen
                    $imageUrl = env('SUPABASE_URL') . '/storage/v1/object/products/' . $imageName;
    
                    // (Opcional) Eliminar la imagen anterior de Supabase si existe
                    if ($producto->imagen) {
                        $oldImageName = basename($producto->imagen);
                        $client->delete('object/products/' . $oldImageName);
                    }
    
                    // Actualizar la imagen en la base de datos
                    $producto->imagen = $imageUrl;
                } else {
                    throw new \Exception("Error al subir la imagen, código de estado: " . $response->getStatusCode());
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
            }
        }
    
        $producto->nombre = $request->nombre ?? $producto->nombre;
        $producto->precio_de_venta = $request->precio_de_venta ?? $producto->precio_de_venta;
        $producto->precio_produccion = $request->precio_produccion ?? $producto->precio_produccion;
    
        // Guardar los cambios
        $producto->save();
    
        return response()->json(['data' => 'Producto actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(['data' => $producto]);
    }
}
