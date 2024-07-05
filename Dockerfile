FROM richarvey/nginx-php-fpm:2.0.0	

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]


# FROM php:8.1.2-apache

# RUN apt-get update && apt-get install -y \
#     libzip-dev \
#     zip \
#     unzip \
#     && docker-php-ext-install zip \
#     && pecl install mongodb \
#     && docker-php-ext-enable mongodb \
#     && apt-get clean

# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN a2enmod rewrite

# WORKDIR /var/www/html

# COPY . .

# RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# RUN composer install --no-dev --optimize-autoloader || \
#     composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-mongodb

# EXPOSE 80
# CMD ["apache2-foreground"]
