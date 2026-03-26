FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
RUN npm ci

COPY resources ./resources
COPY public ./public

RUN npm run build

FROM php:8.4-cli-bookworm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        mbstring \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction \
    && chmod +x docker/start-container.sh

COPY --from=frontend /app/public/build ./public/build

EXPOSE 8080

CMD ["sh", "docker/start-container.sh"]
