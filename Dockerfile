FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

EXPOSE 8000

