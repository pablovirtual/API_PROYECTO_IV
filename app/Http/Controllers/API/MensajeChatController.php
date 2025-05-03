<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MensajeChat;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MensajeChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = MensajeChat::with(['emisor', 'receptor'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $mensajes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emisor_id' => 'required|exists:asesores,id',
            'receptor_id' => 'required|exists:asesores,id',
            'mensaje' => 'required|string',
            'leido' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mensaje = MensajeChat::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Mensaje enviado exitosamente',
            'data' => $mensaje
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mensaje = MensajeChat::with(['emisor', 'receptor'])->find($id);
        
        if (!$mensaje) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mensaje
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mensaje = MensajeChat::find($id);
        
        if (!$mensaje) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'emisor_id' => 'sometimes|required|exists:asesores,id',
            'receptor_id' => 'sometimes|required|exists:asesores,id',
            'mensaje' => 'sometimes|required|string',
            'leido' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mensaje->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Mensaje actualizado exitosamente',
            'data' => $mensaje
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = MensajeChat::find($id);
        
        if (!$mensaje) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mensaje no encontrado'
            ], 404);
        }

        $mensaje->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Mensaje eliminado exitosamente'
        ]);
    }

    /**
     * Get conversation between two asesores.
     */
    public function getConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emisor_id' => 'required|exists:asesores,id',
            'receptor_id' => 'required|exists:asesores,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mensajes = MensajeChat::where(function($query) use ($request) {
                $query->where('emisor_id', $request->emisor_id)
                      ->where('receptor_id', $request->receptor_id);
            })->orWhere(function($query) use ($request) {
                $query->where('emisor_id', $request->receptor_id)
                      ->where('receptor_id', $request->emisor_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $mensajes
        ]);
    }

    /**
     * Mark messages as read.
     */
    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receptor_id' => 'required|exists:asesores,id',
            'emisor_id' => 'required|exists:asesores,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        MensajeChat::where('emisor_id', $request->emisor_id)
            ->where('receptor_id', $request->receptor_id)
            ->where('leido', false)
            ->update(['leido' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mensajes marcados como leídos'
        ]);
    }
}
