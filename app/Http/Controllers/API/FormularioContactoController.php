<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FormularioContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormularioContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formularios = FormularioContacto::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $formularios
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'estado' => 'nullable|in:pendiente,procesado,respondido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $formulario = FormularioContacto::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario enviado exitosamente',
            'data' => $formulario
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $formulario = FormularioContacto::find($id);
        
        if (!$formulario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Formulario no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $formulario
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formulario = FormularioContacto::find($id);
        
        if (!$formulario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Formulario no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255',
            'asunto' => 'sometimes|required|string|max:255',
            'mensaje' => 'sometimes|required|string',
            'estado' => 'nullable|in:pendiente,procesado,respondido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $formulario->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario actualizado exitosamente',
            'data' => $formulario
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formulario = FormularioContacto::find($id);
        
        if (!$formulario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Formulario no encontrado'
            ], 404);
        }

        $formulario->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Formulario eliminado exitosamente'
        ]);
    }

    /**
     * Get formularios by estado.
     */
    public function getByEstado(string $estado)
    {
        // Validar que el estado sea válido
        if (!in_array($estado, ['pendiente', 'procesado', 'respondido'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Estado no válido'
            ], 400);
        }

        $formularios = FormularioContacto::where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $formularios
        ]);
    }
}
