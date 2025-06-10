# 1. Base y dependencias
FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y git zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip gd \
 && rm -rf /var/lib/apt/lists/*

# 2. Instalar Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Clonar repo y preparar Laravel
WORKDIR /var/www/html
RUN git clone https://github.com/elmloko/trackpak.git . \
 && composer install --no-interaction --optimize-autoloader \
 && cp .env.example .env \
 && php artisan key:generate

# 4. Copiar entrypoint que ajusta permisos en cada arranque
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 5. Exponer PHP-FPM y setear entrypoint
EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
