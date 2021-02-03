FROM php:apache-buster

ARG USER_ID
ARG GROUP_ID

RUN addgroup --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user

RUN apt-get update && apt-get install gcc-8-base libicu-dev
RUN docker-php-ext-install intl && docker-php-ext-install mysqli && a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-enabled/

EXPOSE 80