FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    composer \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

