#!/bin/bash

cd /app

echo "Provisioning Laravel..."
dirs=( "/app/storage/app/public" "/app/storage/framework/cache" "/app/storage/framework/sessions" "/app/storage/framework/testing" "/app/storage/framework/views" "/app/storage/logs" )

for i in "${dirs[@]}"; do
	[ -d "$i" ] || mkdir -p $i
done

chmod -R 777 /app/storage

php artisan migrate --force
php artisan clear-compiled
php artisan cache:clear
php artisan view:clear
php artisan route:cache
php artisan config:cache
php artisan storage:link
