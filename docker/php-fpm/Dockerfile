# Step 1: Builder
FROM php:8.4-rc-fpm-alpine3.21 AS builder

## 1.1 Symfony deps: bcmath intl pdo
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install bcmath intl pdo

## 1.2 MySQL
RUN docker-php-ext-install mysqli pdo_mysql

## 1.3 XDebug
RUN apk add --update linux-headers \
    && apk --no-cache add ${PHPIZE_DEPS} \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

## 1.4 Redis
RUN apk add --update linux-headers \
    && apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis.so

## 1.5 libzip
RUN apk add libzip-dev zip \
    && apk add --no-cache libzip \
    && docker-php-ext-install zip

## Install Symfony-cli
RUN apk add --no-cache bash \
&& curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
&& apk add symfony-cli

RUN wget -O /usr/local/bin/php-fpm-healthcheck \
https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
&& chmod +x /usr/local/bin/php-fpm-healthcheck

#-----------------------------------------------------------------------------------------------------------------------

# Step 2: Final
FROM php:8.4-rc-fpm-alpine3.21

## Dependencies
### 1. intl
RUN apk add icu \
### 2. libzip
    libzip \
### healthcheck
    fcgi sed grep

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

## Install symfony-cli
COPY --from=builder /usr/bin/symfony /usr/bin/symfony

## Install healthcheck
COPY --from=builder /usr/local/bin/php-fpm-healthcheck /usr/local/bin/php-fpm-healthcheck

## Install composer
COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

## Create user
ARG DOCKER_HOST_UID=1000
RUN echo http://mirror.yandex.ru/mirrors/alpine/edge/community/ >> /etc/apk/repositories \
    && apk add --no-cache --virtual usermod shadow \
    && usermod -u $DOCKER_HOST_UID www-data

## Init logs
### Common log folder
RUN mkdir /usr/local/log \
    && chown -R www-data:www-data /usr/local/log \
### Slow log
    && touch /usr/local/log/www.log.slow \
    && chown www-data:www-data /usr/local/log/www.log.slow \
### Access log
    && touch /usr/local/log/www.access.log \
    && chown www-data:www-data /usr/local/log/www.access.log

COPY php.ini /usr/local/etc/php/php.ini
COPY fpm-increase-timeout-for-debugging.conf /usr/local/etc/php-fpm.d/increase-timeout-for-debugging.conf

WORKDIR /var/www/project