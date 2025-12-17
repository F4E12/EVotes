# ===========================
# Stage 1: Build Vite assets (Sama seperti sebelumnya)
# ===========================
FROM node:20 AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ===========================
# Stage 2: Laravel PHP
# ===========================
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash git zip unzip curl \
    libpng-dev libxml2-dev oniguruma-dev postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel source
COPY . .

# Copy Vite build output dari Stage 1
COPY --from=node-builder /app/public/build ./public/build

# --- TAMBAHAN PENTING ---
# Hapus file 'hot' agar Laravel tahu untuk menggunakan file production (build)
# Hapus juga node_modules lokal jika tidak sengaja ikut ter-copy
RUN rm -rf public/hot node_modules

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

# Pastikan cache config dihapus agar tidak menyimpan path development
CMD ["sh", "-c", "php artisan optimize:clear && php artisan serve --host=0.0.0.0 --port=8000"]
