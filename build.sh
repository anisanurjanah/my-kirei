#!/usr/bin/env bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Copy .env if needed
cp .env.example .env

# Generate app key
php artisan key:generate

# Migrate database (opsional)
php artisan migrate --force

# Install JS dependencies and build
npm install && npm run build
