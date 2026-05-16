#!/bin/bash
# Quick setup script for GestionBovins development environment

set -e

echo "🚀 GestionBovins Setup Script"
echo "=============================="
echo ""

# Check if in correct directory
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found. Run this script from project root."
    exit 1
fi

echo "📦 Step 1: Installing PHP dependencies..."
composer install

echo ""
echo "🔑 Step 2: Generating application key..."
php artisan key:generate

echo ""
echo "🗄️  Step 3: Creating database..."
echo "   Make sure MySQL is running and run these commands:"
echo "   mysql -u root -p"
echo "   > CREATE DATABASE IF NOT EXISTS gestionbovins;"
echo "   > CREATE USER IF NOT EXISTS 'gestionbovins'@'localhost' IDENTIFIED BY 'gestionbovins_password';"
echo "   > GRANT ALL PRIVILEGES ON gestionbovins.* TO 'gestionbovins'@'localhost';"
echo "   > FLUSH PRIVILEGES;"
echo ""
read -p "Press Enter after creating the database..."

echo ""
echo "📊 Step 4: Running migrations..."
php artisan migrate

echo ""
echo "🌱 Step 5: Seeding sample data..."
php artisan db:seed

echo ""
echo "✅ Setup Complete!"
echo ""
echo "To start the development server, run:"
echo "   php artisan serve"
echo ""
echo "Then visit: http://localhost:8000"
