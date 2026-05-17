#!/bin/sh
set -e

cd /app

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Discover packages, cache config and routes
php artisan package:discover --ansi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link 2>/dev/null || true

# Start PHP server (Railway manages the port via $PORT)
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
