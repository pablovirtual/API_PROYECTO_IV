<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return response()->json([
            'status' => 'success',
            'data' => $videos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_video' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $video = Video::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Video agregado exitosamente',
            'data' => $video
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::find($id);
        
        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $video
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::find($id);
        
        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'url_video' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $video->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Video actualizado exitosamente',
            'data' => $video
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);
        
        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video no encontrado'
            ], 404);
        }

        $video->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Video eliminado exitosamente'
        ]);
    }
}
