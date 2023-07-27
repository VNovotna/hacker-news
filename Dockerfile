FROM php:8.2-cli-alpine

RUN apk add --no-cache libzip-dev

RUN docker-php-ext-install -j$(nproc) zip \
  && docker-php-ext-enable zip 

WORKDIR /app

COPY composer* .
COPY src/ src/

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction

ENTRYPOINT [ "php", "src/app.php"]
