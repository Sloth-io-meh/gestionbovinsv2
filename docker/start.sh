#!/bin/sh

echo "==> Generating app key if missing..."
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

echo "==> Discovering packages..."
php artisan package:discover --ansi || true

echo "==> Caching routes/views (config reads live env vars at runtime)..."
php artisan route:cache || true
php artisan view:cache  || true

echo "==> Running migrations..."
php artisan migrate --force || echo "WARNING: migrate failed — check DB_* env vars"

echo "==> Seeding legacy data if tables are empty..."
php artisan tinker --execute="if(DB::table('bovins')->count()==0){Artisan::call('db:seed',['--class'=>'LegacyDataSeeder','--force'=>true]);echo 'Seeded!';}else{echo 'Already seeded, skipping.';}" 2>&1 || true

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Rendering nginx config for port ${PORT:-8080}..."
export NGINX_PORT="${PORT:-8080}"
envsubst '${NGINX_PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

echo "==> Starting nginx + php-fpm via supervisord..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
