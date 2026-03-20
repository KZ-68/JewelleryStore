#!/bin/sh
set -e

echo "Démarrage de l'application..."

# Installer les dépendances si besoin
if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Attente DB
echo "Attente base de données..."
until php -r "
try {
    new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
"; do
    sleep 2
done

echo "DB OK"

# Migrations
php artisan migrate --force || true

# Cache Laravel
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Permissions
chmod -R 775 storage bootstrap/cache || true

echo "Lancement FrankenPHP..."

exec frankenphp run --config /etc/caddy/Caddyfile

if [ ! -f /var/log/frankenphp/access.log]; then
	touch /var/log/frankenphp/access.log
	chmod 644 /var/log/frankenphp/access.log
fi

	echo 'PHP app ready!'
fi