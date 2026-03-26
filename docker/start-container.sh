#!/bin/sh
set -eu

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache

php artisan storage:link || true

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

php artisan config:clear
php artisan view:clear

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
