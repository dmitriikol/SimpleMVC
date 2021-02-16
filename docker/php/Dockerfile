FROM php:7.4-fpm

RUN apt-get update -qq && \
    apt-get dist-upgrade -qqy && \
    apt-get install libpq-dev libicu-dev -qqy && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl pdo pdo_pgsql pgsql
