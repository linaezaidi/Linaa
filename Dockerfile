# Utiliser une image de base PHP
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev && \
    docker-php-ext-install zip


# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier le code source de votre projet
WORKDIR /var/www/html
COPY . .

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Exposer le port utilisé par PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
