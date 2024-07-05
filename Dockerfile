# Use the official PHP image with Apache as the web server
FROM php:8.1.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean

# Copy and install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to the working directory
COPY . .

# Set permissions for Laravel
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Set ServerName to localhost
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader || \
    composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-mongodb

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]
