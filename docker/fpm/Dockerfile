FROM php:7.2.9-fpm

RUN pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd
