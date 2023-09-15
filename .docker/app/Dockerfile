FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    gnupg \
    netcat-traditional \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && pecl install redis

# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
RUN docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:2.5.1 /usr/bin/composer /usr/bin/composer

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
RUN echo memory_limit = 2G >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;