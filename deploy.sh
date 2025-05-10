#!/usr/bin/env bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Copy .env if needed
cp .env.example .env

# Install JS dependencies and build
npm install && npm run build

# Build React app and serve it (pastikan React di-build dan bisa diakses)
npm run dev
