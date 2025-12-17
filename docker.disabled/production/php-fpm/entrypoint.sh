#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ ! "$(ls -A /var/www/storage)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/storage-init/. /var/www/storage
  chown -R www-data:www-data /var/www/storage
fi

# Remove storage-init directory
rm -rf /var/www/storage-init

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
#php artisan migrate --force

#Temporary fix
# Only run migrations if the database is empty
DB_CHECK=$(php -r "
\$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
\$tables = \$pdo->query('SHOW TABLES')->fetchAll();
echo count(\$tables);
")

if [ "$DB_CHECK" -eq 0 ]; then
    echo "Running Laravel migrations..."
    php artisan migrate --force
else
    echo "Database already has tables, skipping migrations."
fi
##

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"
