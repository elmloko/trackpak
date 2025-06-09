FROM laravelsail/php82-composer:latest

# Instala extensiones requeridas
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Copia los archivos al contenedor (si no usas volumen en Compose)
# COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html
