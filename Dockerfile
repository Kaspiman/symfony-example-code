FROM php:7.4.13-fpm-alpine AS backend

RUN apk --no-cache add --virtual .build \
        $PHPIZE_DEPS \
        bash \
        busybox-suid \
        freetype-dev \
        git \
        libbz2 \
        libmcrypt-dev \
        libpcre32 \
        libressl-dev \
        unzip \
        zip \
        zlib-dev \
        libzip-dev \
        openssh

RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql pcntl

RUN docker-php-ext-enable opcache && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php-fpm/php.ini /usr/local/etc/php
COPY docker/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d
COPY docker/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY docker/php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]

CMD ["/bin/sh", "-c", "php-fpm"]

WORKDIR /var/www/html

COPY --chown=www-data:www-data composer.json composer.lock symfony.lock ./

RUN composer install -q --no-ansi --no-interaction --no-progress --no-suggest --optimize-autoloader --no-scripts

COPY --chown=www-data:www-data . ./

RUN composer run-script post-install-cmd

##########
# Frontend
##########
FROM nginx:1.19-alpine AS frontend

EXPOSE 80

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/sites-available /etc/nginx/sites-available

WORKDIR /var/www/html

COPY --from=backend --chown=nginx:nginx /var/www/html/public /var/www/html/public
