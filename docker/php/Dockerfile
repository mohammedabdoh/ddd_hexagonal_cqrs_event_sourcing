ARG VERSION
ARG COMPOSER_VERSION

# Dev image
FROM composer:${COMPOSER_VERSION} AS composer
FROM php:${VERSION}-fpm-alpine AS dev
RUN apk update && \
    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make && \
    apk add --no-cache zlib-dev libzip-dev
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql zip
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN echo 'error_reporting = E_ERROR' >> /usr/local/etc/php/conf.d/docker-php-error-handling.ini
WORKDIR /var/www/html

# Test image
FROM dev AS test
WORKDIR /var/www/html
COPY . .
RUN composer install --no-interaction --optimize-autoloader
RUN chown -R www-data:www-data .

# Production image
FROM test AS prod
RUN rm -rf ./vendor
RUN rm -rf ./var
RUN composer install --no-dev --no-interaction --optimize-autoloader
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN apk del dev-deps