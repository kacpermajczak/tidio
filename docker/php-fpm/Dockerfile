FROM php:8.0-fpm
WORKDIR "/application"

# UPDATE
RUN apt update

# PACKAGES
RUN apt-get install -y \
        zip \
        libzip-dev \
        wget \
        curl \
        unzip \
        libicu-dev

#add intl for number_formatter used in money library
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

#add composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

#add bcmath for moneyphp/money library
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo_mysql