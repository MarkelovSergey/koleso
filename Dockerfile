FROM php:8.2-cli

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./composer.json /app

COPY ./index.php /app

COPY ./.env /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev 

RUN composer install

CMD ["php", "index.php", "$1"]