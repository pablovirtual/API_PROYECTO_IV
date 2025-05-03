<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Valoracion;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valoraciones = Valoracion::with('asesor')->get();
        return response()->json([
            'status' => 'success',
            'data' => $valoraciones
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asesor_id' => 'required|exists:asesores,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $valoracion = Valoracion::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Valoración creada exitosamente',
            'data' => $valoracion
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $valoracion = Valoracion::with('asesor')->find($id);
        
        if (!$valoracion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Valoración no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $valoracion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $valoracion = Valoracion::find($id);
        
        if (!$valoracion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Valoración no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'asesor_id' => 'sometimes|required|exists:asesores,id',
            'calificacion' => 'sometimes|required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $valoracion->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Valoración actualizada exitosamente',
            'data' => $valoracion
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $valoracion = Valoracion::find($id);
        
        if (!$valoracion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Valoración no encontrada'
            ], 404);
        }

        $valoracion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Valoración eliminada exitosamente'
        ]);
    }

    /**
     * Get valoraciones by asesor.
     */
    public function getByAsesor(string $asesorId)
    {
        $asesor = Asesor::find($asesorId);
        
        if (!$asesor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Asesor no encontrado'
            ], 404);
        }

        $valoraciones = Valoracion::where('asesor_id', $asesorId)->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $valoraciones
        ]);
    }
}
