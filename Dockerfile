FROM php:8.4-cli

# Install PHP dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libicu-dev libpng-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install intl zip pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Buat ulang folder storage (di-exclude oleh .dockerignore) satu per satu.
# PENTING: jangan pakai brace expansion {a,b,c} di sini, karena RUN default
# jalan pakai /bin/sh (dash) yang TIDAK mendukung syntax itu — sebelumnya ini
# menyebabkan folder storage/framework/views tidak benar-benar terbuat,
# yang berujung error "Please provide a valid cache path" di Blade Compiler.
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP packages
RUN composer install --no-dev --optimize-autoloader

# Install Node packages & build Vite
RUN npm install
RUN npm run build

# Bersihkan SEMUA cache lama (config, route, view) biar tidak ada file cache
# basi yang ikut ter-bundle dari repo/build sebelumnya. Route cache lama bisa
# menyebabkan Laravel salah baca method HTTP suatu route (mis. 405 Method
# Not Allowed) walau kode route di repo sudah benar.
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan cache:clear

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan serve --host=0.0.0.0 --port=$PORT"]