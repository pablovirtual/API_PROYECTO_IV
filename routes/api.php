<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AsesorController;
use App\Http\Controllers\API\PreguntaFrecuenteController;
use App\Http\Controllers\API\GaleriaImagenController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\ValoracionController;
use App\Http\Controllers\API\MensajeChatController;
use App\Http\Controllers\API\FormularioContactoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta para la raíz de la API
Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API conectada correctamente',
        'version' => '1.0',
        'endpoints' => [
            'public' => [
                '/api/login' => 'Autenticación de usuarios',
                '/api/home' => 'Información general de la aplicación',
                '/api/contacto' => 'Envío de formularios de contacto',
                '/api/preguntas-frecuentes' => 'Listado de FAQs'
            ],
            'protected' => [
                '/api/asesores' => 'Gestión de asesores',
                '/api/galeria' => 'Gestión de la galería de imágenes',
                '/api/videos' => 'Gestión de videos',
                '/api/valoraciones' => 'Gestión de valoraciones',
                '/api/chat' => 'Sistema de mensajería'
            ]
        ]
    ]);
});

// Health check en la API
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

// Rutas públicas
Route::post('login', [AsesorController::class, 'login']);
Route::post('contacto', [FormularioContactoController::class, 'store']);

// Ruta home para la página principal
Route::get('home', function () {
    return response()->json([
        'status' => 'success',
        'data' => [
            'title' => 'Bienvenido a nuestra plataforma de asesorías',
            'welcome_message' => 'Conectamos a estudiantes con asesores profesionales',
            'features' => [
                [
                    'title' => 'Asesoría personalizada',
                    'description' => 'Nuestros asesores están disponibles para atender tus consultas específicas'
                ],
                [
                    'title' => 'Material didáctico',
                    'description' => 'Accede a videos y recursos didácticos de alta calidad'
                ],
                [
                    'title' => 'Comunicación directa',
                    'description' => 'Chat en vivo con los mejores asesores en diferentes especialidades'
                ]
            ],
            'stats' => [
                'asesores' => 20,
                'estudiantes' => 500,
                'valoracion_promedio' => 4.8
            ]
        ]
    ]);
});

// Preguntas Frecuentes
Route::get('preguntas', [PreguntaFrecuenteController::class, 'index']);
Route::get('preguntas/{id}', [PreguntaFrecuenteController::class, 'show']);
Route::get('preguntas/categoria/{categoria}', [PreguntaFrecuenteController::class, 'getByCategoria']);

// Galería de Imágenes
Route::get('galeria', [GaleriaImagenController::class, 'index']);
Route::get('galeria/{id}', [GaleriaImagenController::class, 'show']);

// Videos
Route::get('videos', [VideoController::class, 'index']);
Route::get('videos/{id}', [VideoController::class, 'show']);

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Rutas de usuario autenticado
    Route::post('logout', [AsesorController::class, 'logout']);
    
    // CRUD de Asesores
    Route::get('asesores', [AsesorController::class, 'index']);
    Route::post('asesores', [AsesorController::class, 'store']);
    Route::get('asesores/{id}', [AsesorController::class, 'show']);
    Route::put('asesores/{id}', [AsesorController::class, 'update']);
    Route::delete('asesores/{id}', [AsesorController::class, 'destroy']);
    
    // CRUD de Preguntas Frecuentes (administración)
    Route::post('preguntas', [PreguntaFrecuenteController::class, 'store']);
    Route::put('preguntas/{id}', [PreguntaFrecuenteController::class, 'update']);
    Route::delete('preguntas/{id}', [PreguntaFrecuenteController::class, 'destroy']);
    
    // CRUD de Galería de Imágenes (administración)
    Route::post('galeria', [GaleriaImagenController::class, 'store']);
    Route::post('galeria/upload', [GaleriaImagenController::class, 'upload']);
    Route::put('galeria/{id}', [GaleriaImagenController::class, 'update']);
    Route::delete('galeria/{id}', [GaleriaImagenController::class, 'destroy']);
    
    // CRUD de Videos (administración)
    Route::post('videos', [VideoController::class, 'store']);
    Route::put('videos/{id}', [VideoController::class, 'update']);
    Route::delete('videos/{id}', [VideoController::class, 'destroy']);
    
    // Valoraciones
    Route::get('valoraciones', [ValoracionController::class, 'index']);
    Route::post('valoraciones', [ValoracionController::class, 'store']);
    Route::get('valoraciones/{id}', [ValoracionController::class, 'show']);
    Route::put('valoraciones/{id}', [ValoracionController::class, 'update']);
    Route::delete('valoraciones/{id}', [ValoracionController::class, 'destroy']);
    Route::get('valoraciones/asesor/{asesorId}', [ValoracionController::class, 'getByAsesor']);
    
    // Mensajes Chat
    Route::get('mensajes', [MensajeChatController::class, 'index']);
    Route::post('mensajes', [MensajeChatController::class, 'store']);
    Route::get('mensajes/{id}', [MensajeChatController::class, 'show']);
    Route::put('mensajes/{id}', [MensajeChatController::class, 'update']);
    Route::delete('mensajes/{id}', [MensajeChatController::class, 'destroy']);
    Route::post('mensajes/conversacion', [MensajeChatController::class, 'getConversation']);
    Route::post('mensajes/marcar-leido', [MensajeChatController::class, 'markAsRead']);
    
    // Formularios de Contacto (administración)
    Route::get('contacto', [FormularioContactoController::class, 'index']);
    Route::get('contacto/{id}', [FormularioContactoController::class, 'show']);
    Route::put('contacto/{id}', [FormularioContactoController::class, 'update']);
    Route::delete('contacto/{id}', [FormularioContactoController::class, 'destroy']);
    Route::get('contacto/estado/{estado}', [FormularioContactoController::class, 'getByEstado']);
    
    // Health check en la API
    Route::get('/health', function () {
        return response()->json(['status' => 'ok'], 200);
    });
});
