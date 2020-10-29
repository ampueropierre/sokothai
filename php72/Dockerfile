FROM php:7.2-apache

EXPOSE 80

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git gnupg unzip zip;

RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
COPY php.ini /usr/local/etc/php/conf.d/app.ini

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

COPY php.ini /usr/local/etc/php/conf.d/app.ini

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN addgroup --system pedro --gid 1000 && adduser --system pedro --uid 1000 --ingroup pedro

COPY vhost.conf /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite

WORKDIR /var/www/