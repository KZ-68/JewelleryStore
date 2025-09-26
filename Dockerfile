FROM php:8.3-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    nano \
    sqlite3 \
    libsqlite3-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip sockets

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-interaction --optimize-autoloader --no-scripts

RUN composer require laravel/breeze --dev \
    && composer require laravel/sanctum \
    && composer require laravel/octane \
    && composer require laravel/sail --dev \
    && composer require laravel/cashier \
    && composer require barryvdh/laravel-dompdf \
    && composer require spatie/laravel-permission \

RUN php artisan breeze:install \
    && php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" \
    && php artisan octane:install

RUN php artisan octane:install --server=frankenphp --no-interaction

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www

EXPOSE 8000

ENTRYPOINT ["/var/www/docker/entrypoint.sh"]