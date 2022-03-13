#!/bin/sh

# TODO: global env vars aren't used.
cat > /app/.env.production << EOF
APP_NAME=MyIdlers
APP_DEBUG=false
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
APP_URL=${APP_URL}
ASSET_URL=${ASSET_URL}
EOF

# TODO: only run this once
php artisan key:generate
php artisan migrate:fresh --seed --force
php artisan serve --host=0.0.0.0 --port=8000 --env=production
