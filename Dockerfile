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

# Copy composer files + artisan (post-autoload hook needs artisan to exist)
COPY composer.json composer.lock artisan ./
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress

# Copy package files and build frontend assets
COPY package.json package-lock.json vite.config.js postcss.config.js tailwind.config.js ./
RUN npm ci --omit=dev
COPY resources ./resources
COPY public ./public
RUN npm run build

# Copy remaining application code
COPY . .

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
