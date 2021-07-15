#
# PHP Dependencies
#
FROM composer:latest as vendor

WORKDIR /

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

#
# Node
#
FROM node:11.14 as node

COPY ./node /var/www/html

RUN cd /var/www/html && \
    npm install

#
# Application
#
FROM leroymerlinbr/php:7.4-fpm-nginx

USER root

RUN apt-get update && \
    apt install -y --no-install-recommends \
        nodejs

COPY . /var/www/html

COPY --from=vendor /vendor/ /var/www/html/vendor
COPY --from=node  /var/www/ /var/www/html/node

RUN touch /var/www/html/storage/database/database.sqlite

RUN chown -R 1000.1000 /var/www/html

USER www-data

RUN composer du

WORKDIR /var/www/html
