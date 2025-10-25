# Use the official PHP 7.2 image as the base
FROM php:7.2-apache

# Fix Buster repository issues by pointing to archive.debian.org
RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/security.debian.org/d' /etc/apt/sources.list

# Install system dependencies and PHP extensions required for Laravel
RUN apt-get update -o Acquire::Check-Valid-Until=false \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        unzip \
        git \
        curl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite (important for Laravel)
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the Laravel application into the container
COPY ../ /var/www/html

# Set proper permissions for Laravel storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies using Composer as www-data to avoid permission issues
USER www-data
RUN composer install --no-interaction --optimize-autoloader
USER root

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

