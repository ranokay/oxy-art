FROM php:8.1-apache
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql