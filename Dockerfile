FROM php:8.1-apache
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql
RUN apt-get install -y  apache2

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]