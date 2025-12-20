FROM node:20 AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash git zip unzip curl \
    libpng-dev libxml2-dev oniguruma-dev postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=node-builder /app/public/build ./public/build

RUN rm -rf public/hot node_modules

RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link || true
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan optimize:clear && php artisan serve --host=0.0.0.0 --port=8000"]
