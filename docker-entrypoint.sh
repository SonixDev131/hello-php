#!/bin/bash
set -e

# Fix permissions for mounted volumes
chown -R www-data:www-data /var/www/storage
chmod -R 755 /var/www/storage

# Make sure the storage directory is writable
chmod 755 /var/www/storage

# Start Apache
exec apache2-foreground
