#!/bin/sh
# Forzar permisos correctos sobre storage y cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775             /var/www/html/storage /var/www/html/bootstrap/cache

# También asegúrate de los subdirectorios que Laravel usa
mkdir -p /var/www/html/storage/logs \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775             /var/www/html/storage /var/www/html/bootstrap/cache

# Finalmente, ejecutar el comando original
exec "$@"
