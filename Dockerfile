# Start from the Laravel Sail PHP 8.1 Composer image
FROM laravelsail/php81-composer

# Set environment variables to avoid interactive prompts during package installation
ENV DEBIAN_FRONTEND=noninteractive

# Update and install required dependencies
RUN apt-get update -y && \
    apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        zip \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd exif intl zip

# Set up the group and user with appropriate IDs
ARG WWWGROUP=1000
ARG WWWUSER=1000

RUN echo "Creating group with GID: $WWWGROUP and user with UID: $WWWUSER" && \
    groupadd -g $WWWGROUP sail || true && \
    useradd -m -u $WWWUSER -g $WWWGROUP -s /bin/bash sail

# Set working directory
WORKDIR /var/www/html

# Expose the application port
EXPOSE 80

# Switch to 'sail' user for security
USER sail

# Default command to run PHP-FPM
CMD ["php-fpm"]
