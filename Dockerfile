FROM php:8.0-fpm-alpine
# FROM php:7.4.3-fpm-alpine

RUN apk add --no-cache nginx wget

# RUN apk add --no-cache bash

# RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - 
RUN apk add --no-cache nodejs npm

# Install dependencies for GD and install GD with support for jpeg, png webp and freetype
# Info about installing GD in PHP https://www.php.net/manual/en/image.installation.php
RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libxml2-dev \
        libzip-dev

RUN apk upgrade

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-enable pdo_mysql

# As of PHP 7.4 we don't need to add --with-png
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype

RUN docker-php-ext-install gd

RUN docker-php-ext-install soap

RUN docker-php-ext-install zip

RUN docker-php-ext-install bcmath

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN cd /app && \
    /usr/bin/npm install

RUN cd /app && \
    /usr/bin/npm run prod

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
