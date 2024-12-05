<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

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
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'piezas' => 'required|boolean',
        'publico' => 'required|boolean',
    ]);

    // Verifica si hay un archivo para subir
    if ($request->hasFile('imagen')) {
        $image = $request->file('imagen');
        $imageName = time() . '_' . $image->getClientOriginalName(); // Nombre único del archivo

        // Usa Guzzle para subir el archivo a Supabase Storage
        try {
            $client = new Client([
                'base_uri' => env('SUPABASE_URL') . '/storage/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
                ],
            ]);

            $response = $client->post('object/products/' . $imageName, [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($image->getPathname(), 'r'),
                        'filename' => $imageName,
                    ],
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return response()->json(['error' => 'Error al subir la imagen a Supabase'], 500);
            }

            // Genera la URL pública de la imagen
            $imageUrl = env('SUPABASE_URL') . '/storage/v1/object/products/' . $imageName;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al subir la imagen: ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'No se encontró ninguna imagen para subir'], 400);
    }

    // Guardar el producto en la base de datos
    Producto::create([
        'nombre' => $request->nombre,
        'precio_de_venta' => $request->precio_de_venta,
        'precio_produccion' => $request->precio_produccion,
        'imagen' => $imageUrl, // Guardar la URL pública
        'piezas' => $request->piezas,
        'for_public' => $request->publico,
    ]);

    return response()->json(['data' => 'Producto creado exitosamente']);
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
