#!/bin/bash
set -e

echo "Deployment started..."

# Enter maintenance mode
(php artisan down --message 'The application is being quickly updated. Please try again in a minute.') || true

# Update codebase
git pull origin master

# Install dependencies based on lock file
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Migrate database
php artisan migrate --force

# Clear and rebuild cache
php artisan optimize:clear
php artisan optimize

# Restart queue workers
php artisan queue:restart

# Exit maintenance mode
php artisan up

echo "Deployment finished successfully!"
