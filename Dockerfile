# Utiliser une image de base PHP
FROM php:8.1-fpm

# Installer les dépendances nécessaires (ici, Composer et libzip)
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git && \
    docker-php-ext-install zip && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Copier le code source de votre projet
WORKDIR /var/www/html
COPY . .

# Installer les dépendances via Composer
RUN composer install --no-dev --optimize-autoloader

# Exposer le port utilisé par PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
