#!/bin/sh
FILE=.env
if [ ! -f "$FILE" ]; then
    echo 'Creating .env file...'
    cp .env.example .env
fi

echo "Building docker image..."
docker build -t="bivamart/php82-composer" .

echo "Installing composer dependencies..."
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

echo "Stopping running sail container if any..."
./vendor/bin/sail down

echo "Starting app container..."
./vendor/bin/sail up -d

echo "Generating application key..."
./vendor/bin/sail artisan key:generate

sleep 30 & PID=$! #simulate a long process

echo "Processing please be patient..."
printf "["
# While process is running...
while kill -0 $PID 2> /dev/null; do
    printf  "▇"
    sleep 1
done
echo  "]"

echo "Installing bivamart dependncies...????"


FILE=public/storage
if [ ! -h "$FILE" ]; then
    echo "Linking storage path..."
    ./vendor/bin/sail artisan storage:link
fi

echo "Installation Successful!"

echo "- Endpoint: http://localhost"