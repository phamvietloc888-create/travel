web: vendor/bin/heroku-php-nginx public/
release: chmod -R 755 storage bootstrap/cache && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force
