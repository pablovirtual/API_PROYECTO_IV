<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PreguntaFrecuente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreguntaFrecuenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preguntas = PreguntaFrecuente::all();
        return response()->json([
            'status' => 'success',
            'data' => $preguntas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required|string',
            'respuesta' => 'required|string',
            'categoria' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pregunta = PreguntaFrecuente::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Pregunta frecuente creada exitosamente',
            'data' => $pregunta
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pregunta = PreguntaFrecuente::find($id);
        
        if (!$pregunta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pregunta frecuente no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pregunta
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pregunta = PreguntaFrecuente::find($id);
        
        if (!$pregunta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pregunta frecuente no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pregunta' => 'sometimes|required|string',
            'respuesta' => 'sometimes|required|string',
            'categoria' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pregunta->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Pregunta frecuente actualizada exitosamente',
            'data' => $pregunta
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pregunta = PreguntaFrecuente::find($id);
        
        if (!$pregunta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pregunta frecuente no encontrada'
            ], 404);
        }

        $pregunta->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pregunta frecuente eliminada exitosamente'
        ]);
    }

    /**
     * Get preguntas by categoria.
     */
    public function getByCategoria(string $categoria)
    {
        $preguntas = PreguntaFrecuente::where('categoria', $categoria)->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $preguntas
        ]);
    }
}
