FROM composer as vendor

WORKDIR /app

COPY . .

RUN composer update
# CMD [ "composer", "update"]


FROM php:8.3-fpm-alpine

WORKDIR /app

EXPOSE 8000

COPY --from=vendor /app .

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pgsql pdo_pgsql

RUN php artisan key:generate

CMD php artisan serve --host=0.0.0.0