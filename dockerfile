# ===========================
# Stage 1: Node for Vite
# ===========================
FROM node:20-alpine AS node-builder

WORKDIR /var/www

COPY package*.json ./
RUN npm install

COPY . .

# ===========================
# Stage 2: PHP / Laravel
# ===========================
FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    zip \
    unzip \
    curl \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    postgresql-dev \
    autoconf \
    g++ \
    make \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

WORKDIR /var/www

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel code
COPY . .

# Copy node_modules from builder
COPY --from=node-builder /var/www/node_modules ./node_modules

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
