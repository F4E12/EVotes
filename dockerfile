# ===========================
# Stage 1: Node for Vite
# ===========================
FROM node:20 AS node-builder

WORKDIR /var/www

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# ===========================
# Stage 2: PHP / Laravel
# ===========================
FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash git zip unzip curl \
    libpng-dev libxml2-dev oniguruma-dev postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

WORKDIR /var/www

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# Copy ONLY vite build output
COPY --from=node-builder /var/www/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
