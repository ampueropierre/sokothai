FROM php:7.2-apache

EXPOSE 80

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        zlib1g-dev\
        libxml2-dev\
        libzip-dev \
    && docker-php-ext-install \
        zip \
        intl \
        mysqli \
        pdo pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/app.ini

COPY php.ini /usr/local/etc/php/conf.d/app.ini

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN addgroup --system pedro --gid 1000 && adduser --system pedro --uid 1000 --ingroup pedro

COPY vhost.conf /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite

WORKDIR /var/www/