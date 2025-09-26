#!/bin/sh
set -e

if [ -z "$(ls -A 'vendor/' 2>/dev/null)" ]; then
	composer install --prefer-dist --no-progress --no-interaction
fi

MAX_ATTEMPTS=30
SLEEP_SECONDS=2

echo "Vérification de la disponibilité de la base de données..."

attempt=1
until php -r '
try {
    $db = new PDO("mysql:host=" . getenv("DB_HOST") . ";port=" . getenv("DB_PORT") . ";dbname=" . getenv("DB_DATABASE"),
                  getenv("DB_USERNAME"),
                  getenv("DB_PASSWORD"));
    exit(0);
} catch (PDOException $e) {
    exit(1);
}
'; do
    if [ $attempt -ge $MAX_ATTEMPTS ]; then
        echo "La base de données est toujours indisponible après $((MAX_ATTEMPTS * SLEEP_SECONDS)) secondes. Arrêt."
        exit 1
    fi

    echo "Tentative $attempt/$MAX_ATTEMPTS : Base de données indisponible. Nouvelle tentative dans $SLEEP_SECONDS secondes..."
    attempt=$((attempt + 1))
    sleep $SLEEP_SECONDS
done

echo "Base de données disponible."

echo "Migration DB"
php artisan migrate --force

echo "Nettoyage caches"
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Génération clé app Laravel"
php artisan key:generate

echo "Lancer Laravel Octane avec FrankenPHP (via Laravel Octane)"
php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000

php artisan sail:install   # mysql + redis./vendor/bin/sail up -d