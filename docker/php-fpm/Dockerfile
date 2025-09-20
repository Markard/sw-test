# Step 1: Builder
FROM php:8.4-rc-fpm-alpine3.21 AS builder

## 1.1 Symfony deps: bcmath intl pdo
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install bcmath intl pdo

## 1.2 PostgreSQL
RUN apk add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/lib \
    && docker-php-ext-install pdo_pgsql pgsql

## 1.3 MySQL
RUN docker-php-ext-install mysqli pdo_mysql

## 1.4 XDebug
RUN apk add --update linux-headers \
    && apk --no-cache add ${PHPIZE_DEPS} \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

## 1.5 Redis
RUN apk add --update linux-headers \
    && apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis.so

## 1.6 Memcached
ARG MEMCACHED_VERSION=3.3.0
RUN apk add zlib-dev libmemcached-dev git \
    && git clone --branch v$MEMCACHED_VERSION https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached/ \
    && docker-php-ext-configure memcached --disable-memcached-sasl \
    && docker-php-ext-install memcached

## 1.7 RabbitMQ (AMQP)
RUN apk add --update linux-headers \
    && apk --no-cache add rabbitmq-c-dev ${PHPIZE_DEPS} \
    && pecl install amqp \
    && docker-php-ext-enable amqp

## 1.8 Kafka
RUN apk add --update linux-headers \
    && apk --no-cache add librdkafka-dev ${PHPIZE_DEPS} \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

## 1.9 libzip
RUN apk add libzip-dev zip \
    && apk add --no-cache libzip \
    && docker-php-ext-install zip

## 1.10 Swoole
RUN apk add --no-cache libstdc++ libpq && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS curl-dev linux-headers brotli-dev postgresql-dev openssl-dev pcre-dev pcre2-dev sqlite-dev zlib-dev && \
    docker-php-ext-install sockets && \
    mkdir /usr/src/php/ext/swoole && \
    curl -sfL https://github.com/swoole/swoole-src/archive/v6.0.2.tar.gz -o swoole.tar.gz && \
    tar xfz swoole.tar.gz --strip-components=1 -C /usr/src/php/ext/swoole && \
    docker-php-ext-configure swoole \
        --enable-swoole-curl   \
        --enable-mysqlnd       \
        --enable-swoole-pgsql  \
        --enable-swoole-sqlite \
        --enable-brotli        \
        --enable-openssl       \
        --enable-sockets    && \
    docker-php-ext-install -j$(nproc) swoole

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
### 1. Memcached
RUN apk add libmemcached \
### 2. intl
    icu \
### 3. PostgreSQL
    libpq \
### 7. RabbitMQ (AMQP)
    rabbitmq-c \
### 8. Kafka
    librdkafka \
### 9. libzip
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