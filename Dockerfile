FROM composer:2 as vendor
COPY . .
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

FROM php:8.4-fpm-alpine
LABEL maintainer="Equipe de Desenvolvimento"

RUN apk update && apk upgrade && apk add --no-cache \
        libzip-dev \
        libpng-dev \
        libxml2-dev \
        icu-dev \
        mysql-client # Adicionado cliente MySQL se precisar de ferramentas de linha de comando

RUN docker-php-ext-install \
    pdo pdo_mysql \
    bcmath \
    zip \
    intl \
    soap

WORKDIR /var/www/html

COPY --from=vendor /app .

COPY ca.pem .

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]