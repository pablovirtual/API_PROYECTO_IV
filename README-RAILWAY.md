# Despliegue en Railway - Proyecto IV API

## Preparación para el despliegue

Ya has completado los siguientes pasos de preparación:

1. **Creación del Procfile**: Se ha creado un archivo `Procfile` en la raíz del proyecto que indica a Railway cómo ejecutar la aplicación Laravel.

2. **Actualización de composer.json**: Se han añadido los scripts necesarios para el despliegue en Railway.

3. **Actualización de .env.example**: Se ha configurado para usar variables de entorno de Railway.

4. **Configuración de CORS**: Se ha actualizado para permitir conexiones desde tu frontend Angular.

## Pasos para el despliegue

### 1. Preparar el repositorio Git

Si aún no tienes el proyecto en un repositorio Git:

```bash
git init
git add .
git commit -m "Preparación para despliegue en Railway"
```

Luego sube el repositorio a GitHub u otro servicio compatible.

### 2. Despliegue en Railway

#### Opción A: A través de la interfaz web (recomendada)

1. Crea una cuenta en [Railway](https://railway.app/)
2. Haz clic en "New Project" → "Deploy from GitHub"
3. Selecciona tu repositorio
4. Railway detectará automáticamente que es un proyecto Laravel

#### Opción B: A través de la CLI de Railway

1. Instala la CLI de Railway:
   ```bash
   npm i -g @railway/cli
   ```

2. Inicia sesión:
   ```bash
   railway login
   ```

3. Inicia un proyecto:
   ```bash
   railway init
   ```

4. Despliega el proyecto:
   ```bash
   railway up
   ```

### 3. Configurar la base de datos MySQL

1. En el dashboard de Railway, ve a "New" → "Database" → "MySQL"
2. Una vez creada, Railway proporcionará automáticamente las variables de entorno

### 4. Configurar variables de entorno

En la sección "Variables" de tu proyecto en Railway, asegúrate de configurar:

- `APP_KEY`: Genera una nueva clave con `php artisan key:generate --show`
- `APP_ENV`: Establece como `production`
- `APP_DEBUG`: Establece como `false`
- Las variables de entorno de la base de datos se configuran automáticamente al vincular el servicio MySQL

### 5. Ejecutar migraciones de base de datos

En la sección de configuración del proyecto en Railway, añade el siguiente comando para ejecutar después del despliegue:

```bash
php artisan migrate --force
```

### 6. Verificar el despliegue

1. Railway te proporcionará una URL para acceder a tu API
2. Verifica que la API funciona accediendo a `https://tu-url-railway.app/api`
3. Actualiza la URL de la API en tu proyecto Angular para que apunte a esta nueva URL

## Configuración adicional

### Autenticación

Si estás utilizando autenticación basada en Laravel Sanctum (como parece ser el caso según las dependencias), asegúrate de que:

1. La configuración CORS está correctamente establecida (ya lo hemos hecho)
2. Las cookies de sesión están configuradas para el dominio correcto

### WebSockets (futuro)

Para implementar WebSockets para tu sistema de chat en tiempo real:

1. Puedes utilizar Pusher o Laravel Echo Server
2. Railway es compatible con WebSockets a través de servicios como Pusher

## Problemas comunes

- **Error de conexión a la base de datos**: Verifica que las variables de entorno estén correctamente configuradas
- **Errores CORS**: Comprueba la configuración CORS si el frontend no puede conectarse a la API
- **Error de migración**: Si las migraciones fallan, intenta ejecutar `php artisan migrate:fresh --force` desde la terminal de Railway
