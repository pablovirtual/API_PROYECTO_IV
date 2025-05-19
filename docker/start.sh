#!/bin/sh

# Ejecutar script de actualización de seguridad
/update-security.sh

# Iniciar PHP-FPM en segundo plano
php-fpm -D

# Iniciar Nginx en primer plano
nginx -g "daemon off;"
