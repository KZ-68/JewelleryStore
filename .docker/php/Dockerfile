FROM dunglas/frankenphp:1-php8.4 AS frankenphp_upstream
SHELL ["/bin/bash", "-c"]

FROM frankenphp_upstream AS frankenphp_base

ENV SERVER_ROOT=/app

COPY --from=frankenphp_upstream /usr/local/bin/frankenphp /usr/local/bin/frankenphp
COPY --from=frankenphp_upstream /usr/local/lib/php/extensions /usr/local/lib/php/extensions

WORKDIR /app

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
    && docker-php-ext-configure gd --with-freetype --with-jpeg

RUN install-php-extensions \
    @composer \
    exif \
	apcu \
	intl \
    gd \
    pcntl \
    pdo \
    pdo_mysql \
    zip \
    sockets \
    gd \
    bcmath \
    redis

ENV COMPOSER_ALLOW_SUPERUSER=1

ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

COPY --from=frankenphp_upstream /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --link frankenphp/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/
COPY --link --chmod=755 /entrypoint.sh /app/entrypoint
COPY --link frankenphp/Caddyfile /etc/caddy/Caddyfile

ENTRYPOINT ["/app/entrypoint.sh"]

HEALTHCHECK --start-period=120s CMD curl -f http://localhost:2019/metrics || exit 1

FROM frankenphp_base AS frankenphp_dev

ENV APP_ENV=dev XDEBUG_MODE=off
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
	install-php-extensions \
		xdebug \
	;

COPY --link frankenphp/conf.d/20-app.dev.ini $PHP_INI_DIR/app.conf.d/

RUN apt-get update && apt-get install -y chromium chromium-driver fonts-liberation ca-certificates
RUN composer install \
    --optimize-autoloader \
    --no-interaction

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]

FROM frankenphp_base AS frankenphp_prod

ENV APP_ENV=production
ENV SERVER_NAME=joaillerie-orient.tech
ENV FRANKENPHP_CONFIG="import worker.Caddyfile"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --link frankenphp/conf.d/20-app.prod.ini $PHP_INI_DIR/app.conf.d/
COPY --link composer.* ./
RUN set -eux; \
    composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts --no-progress

COPY --link . ./

RUN rm -Rf frankenphp/
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

RUN chmod -R 775 storage bootstrap/cache

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]