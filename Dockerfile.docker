FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libzip-dev \
    mysql-client \
    nodejs \
    npm \
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

# Copy entire application first so artisan and app/ are available
COPY . .

# Install PHP dependencies (skip post-install scripts — artisan needs DB which isn't here yet)
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    && composer dump-autoload --optimize

# Build frontend assets
RUN npm ci --omit=dev && npm run build && rm -rf node_modules

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy service configurations
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
