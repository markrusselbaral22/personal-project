# Start with the PHP and Apache base image
FROM php:8.2.0-apache

# Set working directory
WORKDIR /var/www/html

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install necessary Linux libraries and tools
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    gnupg

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Install npm (optional, if needed)
RUN apt-get install -y npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install gettext intl pdo_mysql gd

RUN docker-php-ext-configure gd --
