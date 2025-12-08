FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos
COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias SIN ejecutar scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Limpiar cualquier cache previo
RUN rm -rf bootstrap/cache/*.php

EXPOSE 8080

# Ejecutar comandos al INICIO, no durante build
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
