FROM php:8.3-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    composer \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

# Development stage - code mounted via volumes
FROM base AS development

# Production stage - code baked into image
FROM base AS production

# Copy composer files first for layer caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY public ./public
COPY migrations ./migrations
COPY phinx.php ./
COPY VERSION ./
COPY php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Set ownership
RUN chown -R www-data:www-data /var/www/html
