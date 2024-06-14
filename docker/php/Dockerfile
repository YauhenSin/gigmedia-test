FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip

RUN docker-php-ext-install pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN addgroup --gid 1000 gigmediagroup
RUN adduser --ingroup gigmediagroup --shell /bin/sh gigmediauser
USER gigmediauser

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
