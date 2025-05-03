# Proyecto IV - API REST con Laravel

## Descripción

Este proyecto es una API REST desarrollada con Laravel para gestionar un sistema de asesorías virtuales. La API permite la gestión de asesores, preguntas frecuentes, galerías de imágenes, videos, valoraciones, mensajes de chat y formularios de contacto.

## Estructura del Proyecto

El proyecto sigue una arquitectura RESTful y está estructurado de la siguiente manera:

### Base de Datos
- **asesores**: Usuarios con rol de asesor
- **preguntas_frecuentes**: Preguntas y respuestas frecuentes organizadas por categorías
- **galeria_imagenes**: Imágenes para la galería del sitio
- **videos**: Enlaces a videos embebidos
- **valoraciones**: Opiniones y calificaciones de los usuarios
- **mensajes_chat**: Sistema de chat entre usuarios y asesores
- **formularios_contacto**: Solicitudes de contacto de usuarios

### Controladores API
Todos los controladores siguen un patrón REST con operaciones CRUD:

- **AsesorController**: Gestión de asesores y autenticación (login/logout)
- **PreguntaFrecuenteController**: Gestión de FAQs por categorías
- **GaleriaImagenController**: Gestión de imágenes con funcionalidad de subida
- **VideoController**: Gestión de enlaces a videos
- **ValoracionController**: Gestión de opiniones y calificaciones
- **MensajeChatController**: Sistema de conversaciones en tiempo real
- **FormularioContactoController**: Gestión de solicitudes de contacto

## Autenticación

La API utiliza Laravel Sanctum para la autenticación basada en tokens:

1. **Login**: `POST /api/login` - Recibe email y password, devuelve un token
2. **Rutas protegidas**: Requieren el header `Authorization: Bearer {token}`
3. **Logout**: `POST /api/logout` - Invalida el token actual

## Endpoints

### Rutas Públicas
- `POST /api/login` - Iniciar sesión
- `POST /api/contacto` - Enviar formulario de contacto
- `GET /api/preguntas` - Obtener todas las preguntas frecuentes
- `GET /api/preguntas/{id}` - Obtener una pregunta específica
- `GET /api/preguntas/categoria/{categoria}` - Filtrar preguntas por categoría
- `GET /api/galeria` - Obtener todas las imágenes de la galería
- `GET /api/galeria/{id}` - Obtener una imagen específica
- `GET /api/videos` - Obtener todos los videos
- `GET /api/videos/{id}` - Obtener un video específico

### Rutas Protegidas (requieren autenticación)
- `POST /api/logout` - Cerrar sesión

#### Asesores
- `GET /api/asesores` - Listar todos los asesores
- `POST /api/asesores` - Crear un nuevo asesor
- `GET /api/asesores/{id}` - Ver un asesor específico
- `PUT /api/asesores/{id}` - Actualizar un asesor
- `DELETE /api/asesores/{id}` - Eliminar un asesor

#### Preguntas Frecuentes
- `POST /api/preguntas` - Crear una nueva pregunta
- `PUT /api/preguntas/{id}` - Actualizar una pregunta
- `DELETE /api/preguntas/{id}` - Eliminar una pregunta

#### Galería de Imágenes
- `POST /api/galeria` - Añadir una nueva imagen
- `POST /api/galeria/upload` - Subir archivo de imagen
- `PUT /api/galeria/{id}` - Actualizar información de imagen
- `DELETE /api/galeria/{id}` - Eliminar una imagen

#### Videos
- `POST /api/videos` - Añadir un nuevo video
- `PUT /api/videos/{id}` - Actualizar información de video
- `DELETE /api/videos/{id}` - Eliminar un video

#### Valoraciones
- `GET /api/valoraciones` - Listar todas las valoraciones
- `POST /api/valoraciones` - Crear una nueva valoración
- `PUT /api/valoraciones/{id}` - Actualizar una valoración
- `DELETE /api/valoraciones/{id}` - Eliminar una valoración

#### Mensajes de Chat
- `GET /api/mensajes` - Listar todos los mensajes
- `POST /api/mensajes` - Crear un nuevo mensaje
- `GET /api/mensajes/conversacion/{id}` - Ver conversación específica
- `DELETE /api/mensajes/{id}` - Eliminar un mensaje

#### Formularios de Contacto
- `GET /api/contacto` - Listar todos los formularios recibidos
- `DELETE /api/contacto/{id}` - Eliminar un formulario

## Configuración e Instalación

1. Clonar el repositorio
2. Ejecutar `composer install`
3. Copiar `.env.example` a `.env` y configurar la conexión a base de datos
4. Generar clave con `php artisan key:generate`
5. Ejecutar migraciones con `php artisan migrate`
6. Opcionalmente, cargar datos de prueba con `php artisan db:seed`
7. Para el sistema de autenticación: `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`

## Pruebas con Postman

Se incluye una colección de Postman (`postman_collection.json`) para probar todos los endpoints. La colección está estructurada en:
- Autenticación
- Rutas Públicas
- Rutas Protegidas

Para usar las rutas protegidas:
1. Ejecutar el endpoint de login
2. Copiar el token recibido
3. En la colección, actualizar la variable `token` o incluir el header de autorización

## Respuestas de la API

Todas las respuestas siguen una estructura consistente:

```json
{
  "status": "success|error",
  "message": "Mensaje descriptivo",
  "data": {
    // Datos de la respuesta (opcional)
  }
}
```

## Errores comunes

- **401 Unauthorized**: Token faltante o inválido
- **404 Not Found**: Recurso no encontrado
- **422 Unprocessable Entity**: Error de validación en los datos enviados

## Futuro desarrollo

- Implementación del frontend con Angular
- Despliegue en entorno de producción (Cloudways)
- Implementación de WebSockets para chat en tiempo real

## Contribución

Este proyecto ha sido desarrollado como parte de un proyecto universitario. Si deseas contribuir, por favor contacta al autor.

## Licencia

Este proyecto es propiedad intelectual del desarrollador y está protegido por las leyes de derechos de autor.
