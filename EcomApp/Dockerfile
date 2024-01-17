FROM php:8.2-apache

COPY --from=composer /usr/bin/composer /usr/bin/composer

# install utils
RUN apt-get update \
    && apt-get install -y \
    git \
    wget \
    curl \
    zip \
    unzip \
    vim \
    nodejs \
    npm \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libzip-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd exif zip

# conf rewrite
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && cd /etc/apache2/mods-enabled \
    && ln -s ../mods-available/rewrite.load