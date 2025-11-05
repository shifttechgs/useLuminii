#!/bin/bash
set -e

echo "🚀 Starting Laravel container setup..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
while ! nc -z db 3306; do
  sleep 1
done
echo "✅ Database is ready!"

# Install/update composer dependencies if needed
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist
else
    echo "✅ Composer dependencies already installed"
fi

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "🔑 Generating application key..."
    php artisan key:generate --no-interaction
else
    echo "✅ Application key already set"
fi

# Create storage symlink if needed
if [ ! -L "public/storage" ]; then
    echo "🔗 Creating storage symlink..."
    php artisan storage:link --no-interaction || true
else
    echo "✅ Storage symlink already exists"
fi

# Set permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Run migrations (uncomment if you want auto-migration)
# echo "🗄️  Running migrations..."
# php artisan migrate --force --no-interaction

echo "✨ Laravel container is ready!"
echo ""

# Execute the main command (php-fpm)
exec "$@"
