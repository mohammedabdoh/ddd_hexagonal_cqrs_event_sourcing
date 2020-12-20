ARG VERSION
ARG COMPOSER_VERSION

# Dev image
FROM composer:${COMPOSER_VERSION} AS composer
FROM php:${VERSION}-fpm-alpine AS dev
ENV APP_ENV=dev
RUN apk update && \
    apk add --no-cache --virtual dev-deps git autoconf gcc g++ make && \
    apk add --no-cache zlib-dev libzip-dev
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql zip

RUN apk update \
    && apk add rabbitmq-c rabbitmq-c-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN echo 'error_reporting = E_ERROR' >> /usr/local/etc/php/conf.d/docker-php-error-handling.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
WORKDIR /var/www/html

# Test image
FROM dev AS test
WORKDIR /var/www/html
COPY . .
RUN composer install --ignore-platform-reqs --no-interaction --optimize-autoloader
RUN chown -R www-data:www-data .

# Production image
FROM test AS prod
ENV APP_ENV=prod
RUN composer install --ignore-platform-reqs --no-interaction --optimize-autoloader --no-dev
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN apk del dev-deps