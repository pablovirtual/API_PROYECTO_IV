#!/bin/sh

# Actualizar paquetes del sistema operativo
apk update
apk upgrade --available

# Ejecutar cualquier comando específico para actualizar paquetes vulnerables conocidos
# Estos nombres de paquetes deben ajustarse según las vulnerabilidades específicas
# reportadas para tu imagen
apk add --no-cache --upgrade busybox ssl_client

# Limpieza
rm -rf /var/cache/apk/*

echo "Security packages updated at startup"
