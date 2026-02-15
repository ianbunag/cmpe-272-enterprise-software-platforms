FROM php:8.3-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    mysql-client \
    git \
    unzip \
    zip \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Get official Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Development stage
FROM base AS development

# Production stage
FROM base AS production

# Copy composer files first for layer caching
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy application code
COPY public ./public
COPY migrations ./migrations
COPY phinx.php ./
COPY VERSION ./
COPY php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Set ownership
RUN chown -R www-data:www-data /var/www/html
