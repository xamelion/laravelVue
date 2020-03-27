FROM php:7.4.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mariadb-client --no-install-recommends curl nano \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer