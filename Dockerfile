FROM php:8.2-fpm-alpine

# Actualizar el sistema base y aplicar parches de seguridad
RUN apk update && \
    apk upgrade --available && \
    apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    libzip-dev \
    # Instalar parches de seguridad disponibles
    busybox \
    ssl_client \
    # Limpiar cache de paquetes para reducir tamaño
    && rm -rf /var/cache/apk/* \
    && docker-php-ext-install zip pdo pdo_mysql

# Establecer variables de seguridad en PHP
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/security.ini && \
    echo "display_errors = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "display_startup_errors = Off" >> /usr/local/etc/php/conf.d/security.ini

# Configurar Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copiar solo los archivos necesarios primero para aprovechar caché
COPY composer.json composer.lock /var/www/html/

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar el resto de los archivos
COPY . /var/www/html

# Permisos para directorios
RUN chmod -R 775 storage bootstrap/cache public \
    && chown -R nobody:nobody /var/www/html

# Configuración de entorno
COPY .env.example .env
RUN php artisan key:generate --force

# Cache de configuración y rutas
RUN php artisan config:cache && php artisan route:cache

# Exponer puerto
EXPOSE 80

# Script para actualización de seguridad
COPY docker/update-security.sh /update-security.sh
RUN chmod +x /update-security.sh

# Script para iniciar tanto PHP-FPM como Nginx
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Healthcheck
HEALTHCHECK --interval=10s --timeout=5s --start-period=30s --retries=3 \
  CMD curl -f http://localhost/health || exit 1

CMD ["/start.sh"]
