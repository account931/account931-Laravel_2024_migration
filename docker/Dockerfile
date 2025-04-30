# Use the official PHP 7.2 image as the base image
FROM php:7.2-apache

# Install system dependencies and PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
	
# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite (important for Laravel)
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html


# Copy the Laravel application into the container
COPY ../ /var/www/html

# Set proper permissions for the Laravel storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies (if you have a composer.json). ERROR IS HERE
RUN composer install --no-interaction --optimize-autoloader

# Expose port 80 for the Apache server
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
