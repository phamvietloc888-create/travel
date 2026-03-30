release: chmod -R 755 storage bootstrap/cache && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force
web: vendor/bin/heroku-php-apache2 public/
