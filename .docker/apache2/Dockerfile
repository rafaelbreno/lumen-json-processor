# PHP 7.4 (to work with Laravel 8)
FROM php:7.4-apache

USER root

WORKDIR /var/www/html

ADD . /var/www/html

RUN apt-get update --fix-missing -q

RUN apt-get install -y apt-utils

RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

COPY .docker/apache2/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data: /var/www/html \
    && a2enmod rewrite

RUN chmod -R 777 /var/www/html/storage /var/www/html/storage/*
