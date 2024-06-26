#!/bin/bash

# Function to display usage
usage() {
    echo "Usage: $0 {build|stop|up|composer-install|data|install}"
    exit 1
}


# Check if an argument is provided
if [ -z "$1" ]; then
    usage
fi

# Execute the appropriate command based on the argument
case "$1" in
    build)
        docker compose build --no-cache --force-rm
        ;;
    stop)
        docker compose stop
        ;;
    up)
        docker compose up -d
        ;;
    install)
        docker cp . laravel-docker:/var/www/html
        docker exec laravel-docker chmod -R 775 ./storage
        docker exec laravel-docker chown -R www-data:www-data ./storage

        ;;
    composer-install)
        docker exec laravel-docker bash -c "cp .env.example .env"
        docker exec laravel-docker bash -c "php artisan key:generate"
        docker exec laravel-docker bash -c "composer install"
        docker exec laravel-docker bash -c "npm run dev"
        
        ;;
    data)
        docker exec laravel-docker bash -c "php artisan migrate"
        docker exec laravel-docker bash -c "php artisan db:seed"
        ;;
    *)
        usage
        ;;
esac
