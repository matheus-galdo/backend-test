FROM composer as vendor

WORKDIR /app

COPY ./composer.* .


FROM php:8.3-fpm-alpine

WORKDIR /app

COPY . .

CMD [ "php", "artisan", "serve" ]