FROM php:8.2-cli

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev 

CMD ["php", "index.php", "$1"]