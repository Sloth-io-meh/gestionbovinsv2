FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libzip-dev \
    mysql-client \
    nodejs \
    npm \
    git \
    gettext \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        bcmath \
    && rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    && composer dump-autoload --optimize

RUN npm ci --omit=dev && npm run build && rm -rf node_modules

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

RUN mkdir -p /var/log/supervisor /var/log/nginx /run/nginx

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
