FROM php:8.3-fpm

ENV UID=1000
ENV GID=1000

RUN addgroup --gid 1000 www && adduser --uid 1000 --gid 1000 --home /home/www --disabled-password --gecos "" www

# Set working directory
WORKDIR /var/www/html

# Install necessary libraries and PHP extensions
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
        $PHPIZE_DEPS \
        vim \
        cmake \
        wget \
        git \
        libfreetype6-dev \
        libfontconfig1-dev \
        libpng-dev \
        libjpeg-dev \
        libc-dev \
        jpegoptim optipng pngquant gifsicle \
        unzip \
        curl \
        libzip-dev \
        libpq-dev \
        pkg-config \
        libssl-dev \
        zlib1g zlib1g-dev \
        libxml2-dev \
        libonig-dev \
        libmemcached-dev \
        libgmp-dev \
        libsqlite3-dev \
        postgresql-client \
        graphviz && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install \
        gd \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        mbstring \
        mysqli \
        exif \
        zip \
        intl \
        soap \
        gmp \
        opcache && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    /usr/local/bin/composer config --global repo.packagist composer https://packagist.org && \
    cd /tmp && \
    curl https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-4.1.6.tgz > mongodb.tar.gz && \
    mkdir -p /etc/mongodb && tar xvzf mongodb.tar.gz -C /etc/mongodb --strip-components 1 && \
    rm -rf /tmp/mongodb.tar.gz /tmp/* && \
    apt-get remove --purge -y $PHPIZE_DEPS && \
    apt-get autoremove -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Set permissions for Composer
RUN mkdir -p /.composer/ && chmod -R 777 /.composer/

# Change current user to www
USER www

# Expose PHP-FPM port
EXPOSE 9000
