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

# Install PHP packages
RUN composer install --no-dev --optimize-autoloader

# Install Node packages & build Vite
RUN npm install
RUN npm run build

CMD php artisan serve --host=0.0.0.0 --port=$PORT