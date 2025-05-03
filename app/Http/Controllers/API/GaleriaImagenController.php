<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GaleriaImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GaleriaImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imagenes = GaleriaImagen::all();
        return response()->json([
            'status' => 'success',
            'data' => $imagenes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'url_imagen' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagen = GaleriaImagen::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Imagen agregada exitosamente',
            'data' => $imagen
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $imagen = GaleriaImagen::find($id);
        
        if (!$imagen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $imagen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $imagen = GaleriaImagen::find($id);
        
        if (!$imagen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'url_imagen' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagen->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Imagen actualizada exitosamente',
            'data' => $imagen
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imagen = GaleriaImagen::find($id);
        
        if (!$imagen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        $imagen->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Imagen eliminada exitosamente'
        ]);
    }

    /**
     * Upload an image file and return the URL.
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imagen' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/imagenes/galeria');
            $url = Storage::url($path);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Imagen subida exitosamente',
                'url' => $url
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No se pudo procesar la imagen'
        ], 400);
    }
}
