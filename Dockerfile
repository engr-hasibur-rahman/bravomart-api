# Use the official PHP image as a base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html

# Install PHP extensions
RUN docker-php-ext-install bcmath

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Run Composer install
RUN composer install --no-dev --optimize-autoloader

# Run npm install and build
RUN npm install && npm run build

# Expose the port Laravel runs on
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
