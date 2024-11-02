#!/bin/bash

# Wait for the database to be ready
./wait-for-it.sh db:5432 --timeout=30 --strict -- echo "Database is ready!"

# Run any command you need here (e.g., migrate the database)
php artisan migrate --force
php artisan db:seed

# Start the PHP-FPM server
php-fpm
