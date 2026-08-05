FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libicu-dev libpng-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install intl zip pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Buat ulang folder storage yang di-ignore, karena tidak ikut ter-copy
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

# Bersihkan cache config lama biar ambil env production yang baru
RUN php artisan config:clear

CMD php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT