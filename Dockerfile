# Multi-stage build for Laravel application
FROM php:8.2-fpm-alpine as php

# Install system dependencies
RUN apk add --no-cache \
    curl \
    libzip-dev \
    mysql-client \
    git \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    zip \
    bcmath \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --no-progress

# Copy application code
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Generate app key
RUN php artisan key:generate --force || true

# Create symbolic link for storage
RUN php artisan storage:link || true

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:9000 || exit 1

EXPOSE 9000

CMD ["php-fpm"]

---

# Nginx web server
FROM nginx:alpine

WORKDIR /var/www/html

# Copy nginx configuration
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy application from PHP stage
COPY --from=php /var/www/html /var/www/html

# Set permissions
RUN chown -R nginx:nginx /var/www/html

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]
