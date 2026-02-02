FROM php:8.4-fpm-alpine

# Install dependencies for PHP extensions
RUN apk add --no-cache linux-headers

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql sockets bcmath pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

ENV APP_ENV=production
EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD php artisan --version || exit 1

ENTRYPOINT ["/app/run.sh"]
