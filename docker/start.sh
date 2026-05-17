#!/bin/sh

cd /app

echo "==> Generating app key if missing..."
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

echo "==> Discovering packages..."
php artisan package:discover --ansi || true

echo "==> Caching routes/views (config NOT cached — reads live env vars)..."
php artisan route:cache || true
php artisan view:cache  || true

echo "==> Running migrations..."
php artisan migrate --force || echo "WARNING: migrate failed — check DB_* env vars"

echo "==> Seeding legacy data if tables are empty..."
php artisan tinker --execute="if(DB::table('bovins')->count()==0){Artisan::call('db:seed',['--class'=>'LegacyDataSeeder','--force'=>true]);echo 'Seeded!';}else{echo 'Already seeded, skipping.';}" 2>&1 || true

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Starting server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
