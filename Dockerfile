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

# # Copiar composer.json primero para cachear vendor
# COPY composer.json composer.lock* ./
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# # Copiar código
# COPY . .

# RUN php artisan key:generate
# RUN php artisan config:clear && php artisan route:clear

# EXPOSE 9000
# CMD ["php-fpm"]