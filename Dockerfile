FROM php:8.2-apache
RUN apt-get update && apt-get install -y unzip && rm -rf /var/lib/apt/lists/*
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 