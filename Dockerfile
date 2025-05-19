FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache

# Puerto que Railway utiliza por defecto
EXPOSE 8080

# Configurar variables importantes para Laravel
ENV APP_ENV=production
ENV APP_DEBUG=false

# Iniciar Laravel en el puerto 8080 que Railway espera
CMD php artisan serve --host=0.0.0.0 --port=8080
