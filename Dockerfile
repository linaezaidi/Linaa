# Étape 1 : Construction de l'application
FROM php:8.1-fpm AS builder

RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Étape 2 : Image finale
FROM php:8.1-fpm AS final

WORKDIR /var/www/html
COPY --from=builder /var/www/html /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
