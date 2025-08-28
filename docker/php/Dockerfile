FROM php:8.2-apache

RUN apt-get update \
	&& apt-get install -y \
    libzip-dev \
	libicu-dev \
    zip

RUN docker-php-ext-install \
	zip \
	intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./ /var/www/html
RUN chown -Rv www-data:www-data /var/www/html;

RUN composer update
