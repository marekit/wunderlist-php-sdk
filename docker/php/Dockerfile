FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer creates=/usr/local/bin/composer

#pdo_mysql
RUN docker-php-ext-install pdo_mysql

#mysqli
RUN docker-php-ext-install mysqli

#soap
RUN apt-get update \
    && apt-get install -y libxml2-dev php-soap \
    && docker-php-ext-install soap

#zip
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

#gd
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

#xdebug
#alternative method for remote host ip: /sbin/ip route|awk '/default/ { print $3 }'
RUN pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host = docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port = 9090" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level = 400" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
