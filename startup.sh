#!/bin/bash

echo "Starting Laravel startup script..."

# Crear directorios necesarios de Laravel
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Permisos
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Si existe storage persistente en Azure
if [ ! -d "/home/site/storage" ]; then
    mkdir -p /home/site/storage
fi

# Crear symlink para persistencia
if [ ! -L "storage" ]; then
    rm -rf storage
    ln -s /home/site/storage storage
fi

# Copiar configuración de nginx personalizada
cp /home/site/wwwroot/default /etc/nginx/sites-available/default

# Recargar nginx
service nginx reload

# Limpiar caches por si quedaron de build
php artisan optimize:clear

# Generar caches optimizados
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Laravel startup completed."
