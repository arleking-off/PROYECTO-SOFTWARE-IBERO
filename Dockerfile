FROM php:8.2-cli 
 
WORKDIR /app 
 
RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip && rm -rf /var/lib/apt/lists/* 
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 
 
COPY . /app 
 
ENV COMPOSER_ALLOW_SUPERUSER=1 
 
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction 
RUN chmod -R 775 storage bootstrap/cache 
 
EXPOSE 8080 
 
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT 
