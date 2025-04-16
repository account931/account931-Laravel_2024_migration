# This is instruction for building container images
# Use PHP 7.2 as base image
FROM php:7.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy the Laravel project files into the container
COPY . .

# Install dependencies (if you have a composer.json)
RUN composer install

# Expose port 9000 to be accessed from outside
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
