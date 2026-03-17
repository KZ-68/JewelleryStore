FROM dunglas/frankenphp:builder AS builder

WORKDIR /app
SHELL ["/bin/bash", "-c"]

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

RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS="-ldflags='-w -s' -tags=nobadger,nomysql,nopgx" \
    CGO_CFLAGS=$(php-config --includes) \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    xcaddy build \
        --output /usr/local/bin/frankenphp \
        --with github.com/dunglas/frankenphp=./ \
        --with github.com/dunglas/frankenphp/caddy=./caddy/ \
        --with github.com/dunglas/caddy-cbrotli \
        --with github.com/dunglas/mercure/caddy \
        --with github.com/dunglas/vulcain/caddy

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --optimize-autoloader --no-scripts

RUN composer require laravel/breeze --dev
RUN composer require laravel/sanctum
RUN composer require laravel/octane
RUN composer require laravel/sail
RUN composer require laravel/cashier
RUN composer require barryvdh/laravel-dompdf
RUN composer require spatie/laravel-permission
RUN composer require tightenco/ziggy

RUN php artisan breeze:install vue --no-interaction
RUN php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
RUN php artisan octane:install

RUN php artisan octane:install --server=frankenphp --no-interaction

# Test package
RUN composer require laravel/pint --dev
RUN composer require phpstan/phpstan --dev

RUN npm install && npm audit fix
RUN npm run build

RUN chown -R www-data:www-data /app

EXPOSE 8000

ENTRYPOINT ["/app/entrypoint.sh"]