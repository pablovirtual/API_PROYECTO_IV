FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN chmod -R 777 /var/www/html/storage

EXPOSE 80

CMD php artisan serve --host=0.0.0.0 --port=80
