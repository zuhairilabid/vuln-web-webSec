FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY src/ /var/www/html/

COPY public/ /var/www/html/public

RUN chown -R www-data:www-data /var/www/html
