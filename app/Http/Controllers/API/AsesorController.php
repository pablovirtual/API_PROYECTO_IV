<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asesores = Asesor::all();
        return response()->json([
            'status' => 'success',
            'data' => $asesores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:asesores',
            'password' => 'required|string|min:8',
            'especialidad' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'imagen_perfil' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $asesor = Asesor::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'especialidad' => $request->especialidad,
            'descripcion' => $request->descripcion,
            'imagen_perfil' => $request->imagen_perfil,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asesor creado exitosamente',
            'data' => $asesor
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asesor = Asesor::find($id);
        
        if (!$asesor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Asesor no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $asesor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asesor = Asesor::find($id);
        
        if (!$asesor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Asesor no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:asesores,email,'.$id,
            'especialidad' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'imagen_perfil' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $asesor->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Asesor actualizado exitosamente',
            'data' => $asesor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asesor = Asesor::find($id);
        
        if (!$asesor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Asesor no encontrado'
            ], 404);
        }

        $asesor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Asesor eliminado exitosamente'
        ]);
    }

    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $asesor = Asesor::where('email', $request->email)->firstOrFail();
        $token = $asesor->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $asesor
        ]);
    }

    /**
     * Logout user and revoke token
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout exitoso'
        ]);
    }
}
