FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos de la aplicación
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos
RUN chmod -R 777 storage bootstrap/cache

# Generar clave de la aplicación si no existe
RUN php artisan key:generate --force

# Optimizar la aplicación
RUN php artisan config:cache && \
    php artisan route:cache

# Exponer puerto (Railway lo configurará en su entorno)
EXPOSE 8080

# Iniciar la aplicación
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
