FROM php:7.3-apache

RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

COPY www /var/www/html/

RUN chown -R www-data:www-data /var/www

EXPOSE 80/tcp
EXPOSE 443/tcp