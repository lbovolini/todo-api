FROM php:apache-buster

RUN apt-get update && apt-get install gcc-8-base libicu-dev
RUN docker-php-ext-install intl && docker-php-ext-install mysqli && a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-enabled/

EXPOSE 80
