FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos
COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Limpiar cache
RUN rm -rf bootstrap/cache/*.php

# Script de inicio
COPY <<'EOF' /start.sh
#!/bin/bash
set -e

echo "Waiting for database..."
until php artisan migrate:status 2>/dev/null || php artisan migrate --force; do
  echo "Database not ready, waiting 2 seconds..."
  sleep 2
done

echo "Running migrations..."
php artisan migrate --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port ${PORT}..."
php artisan serve --host=0.0.0.0 --port=${PORT}
EOF

RUN chmod +x /start.sh

CMD ["/start.sh"]
