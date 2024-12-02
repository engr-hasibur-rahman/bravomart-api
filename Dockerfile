# Start from the Laravel Sail PHP 8.1 Composer image
FROM laravelsail/php81-composer

# Set environment variables to avoid interactive prompts during package installation
ENV DEBIAN_FRONTEND=noninteractive

# Update and install required dependencies
RUN apt-get update -y && \
    apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    && rm -rf /var/lib/apt/lists/*  # Clean up apt cache to reduce image size

# Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install exif gd intl zip

# Set up the group and user with appropriate IDs
ARG WWWGROUP=${WWWGROUP:-1000}  # Default to 1000 if not provided
ARG WWWUSER=${WWWUSER:-1000}    # Default to 1000 if not provided

RUN groupadd --force -g $WWWGROUP sail && \
    useradd --create-home --no-log-init --shell /bin/bash -u $WWWUSER -g $WWWGROUP sail

# Set working directory to /var/www/html
WORKDIR /var/www/html

# Expose the application port
EXPOSE 80

# Set the user to 'sail' to ensure that the application runs with the appropriate permissions
USER sail

# Default command to run PHP-FPM
CMD ["php-fpm"]
