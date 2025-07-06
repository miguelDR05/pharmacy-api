FROM php:8.3-fpm-alpine

# Instala dependencias necesarias para Laravel y PostgreSQL
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    zip \
    curl \
    libpq \
    libpq-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring intl

# Instala Composer copiándolo desde la imagen oficial
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Set folder permissions for Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache
