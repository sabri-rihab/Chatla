# Multi-stage build for Chatla (Laravel 13 + Tailwind CSS + Vite)

# Stage 1: Build Frontend Assets
FROM node:22-alpine AS frontend-builder
WORKDIR /app
COPY Chatla/package*.json ./
RUN npm ci --ignore-scripts || npm install
COPY Chatla/ ./
RUN npm run build

# Stage 2: PHP Application Server (PHP 8.4 required for Laravel 13 & Symfony 8)
FROM php:8.4-cli-bookworm

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    curl \
    && docker-php-ext-install -j$(nproc) bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source
COPY Chatla/ /var/www/html/

# Copy built frontend assets from Stage 1
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# Setup environment and dependencies
RUN cp .env.example .env \
    && composer install --no-interaction --prefer-dist --optimize-autoloader

# Setup storage directory permissions
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create startup entrypoint script inside container to avoid CRLF line-ending issues
RUN printf '#!/bin/sh\n\
set -e\n\
if [ ! -f .env ]; then\n\
  cp .env.example .env\n\
fi\n\
if ! grep -q "APP_KEY=base64:" .env; then\n\
  php artisan key:generate --force\n\
fi\n\
mkdir -p database\n\
touch database/database.sqlite\n\
php artisan migrate:fresh --seed --force\n\
php artisan storage:link || true\n\
echo "🌱 Chatla application is ready at http://localhost:8000"\n\
exec php artisan serve --host=0.0.0.0 --port=8000\n' > /usr/local/bin/chatla-entrypoint.sh \
    && chmod +x /usr/local/bin/chatla-entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/chatla-entrypoint.sh"]
