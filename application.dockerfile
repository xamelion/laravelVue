FROM php:7.4.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    libzip-dev \
    mariadb-client --no-install-recommends curl nano \
    vim \
     libfreetype6-dev \
     libjpeg62-turbo-dev \
     libmcrypt-dev \
     libpng-dev \
     zlib1g-dev \
     libxml2-dev \
     libzip-dev \
     libonig-dev \
     graphviz \
     libcurl4-openssl-dev \
     pkg-config \
     libpq-dev

RUN pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install exif \
    && docker-php-source delete

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add User
RUN useradd -ms /bin/bash xamelion
USER xamelion