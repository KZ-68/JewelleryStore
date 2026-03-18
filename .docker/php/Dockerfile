FROM dunglas/frankenphp:builder AS builder

SHELL ["/bin/bash", "-c"]

COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

RUN set -eux; \
    CGO_ENABLED=1 \
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
        --with github.com/dunglas/vulcain/caddy \
		--with github.com/caddyserver/transform-encoder \
		--with github.com/Javex/caddy-fail2ban@main

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

FROM dunglas/frankenphp:1-php8.4 AS frankenphp_upstream


FROM frankenphp_upstream AS frankenphp_base

COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

WORKDIR /root/JewelleryStore

VOLUME /var/

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

RUN install-php-extensions \
    @composer \
	apcu \
	intl \
    gd \
    pcntl \
    opcache \
    pdo \
    pdo_mysql \
    zip \
    redis

RUN docker-php-ext-install pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER=1

ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

COPY --link frankenphp/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/
COPY --link --chmod=755 /root/JewelleryStore/entrypoint.sh /usr/local/bin/entrypoint
COPY --link frankenphp/Caddyfile /etc/caddy/Caddyfile

ENTRYPOINT ["/root/JewelleryStore/entrypoint.sh"]

HEALTHCHECK --start-period=120s CMD curl -f http://localhost:2019/metrics || exit 1
CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]

FROM frankenphp_base AS frankenphp_dev

ENV APP_ENV=dev XDEBUG_MODE=off

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
		xdebug \
	;

COPY --link frankenphp/conf.d/20-app.dev.ini $PHP_INI_DIR/app.conf.d/

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--watch" ]

RUN set -eux; \
	composer require symfony/amqp-messenger

RUN apt-get update && apt-get install -y chromium chromium-driver fonts-liberation ca-certificates

FROM frankenphp_base AS frankenphp_prod

ENV APP_ENV=prod
ENV FRANKENPHP_CONFIG="import worker.Caddyfile"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --link frankenphp/conf.d/20-app.prod.ini $PHP_INI_DIR/app.conf.d/
COPY --link frankenphp/worker.Caddyfile /etc/caddy/worker.Caddyfile

COPY --link composer.* ./
RUN set -eux; \
    composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts --no-progress

COPY --link . ./
RUN rm -Rf frankenphp/

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

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
RUN php artisan octane:install --server=frankenphp --no-interaction

RUN chown -R www-data:www-data /app

EXPOSE 80 443

RUN ls -la resources/js
