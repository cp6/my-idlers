#!/bin/sh

# Run setup only if .env file doesn't exist.
if [ ! -e .env.production ]
then
cat > .env.production << EOF
APP_NAME=MyIdlers
APP_ENV=production
APP_DEBUG=false
APP_KEY=

LOG_CHANNEL=stderr

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

APP_URL=${APP_URL}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF
php artisan key:generate --no-interaction --force
fi

# Clear and cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if AUTO_MIGRATE is set
if [ "${AUTO_MIGRATE}" = "true" ]; then
    php artisan migrate --force
fi

php artisan serve --host=0.0.0.0 --port=8000 --env=production
