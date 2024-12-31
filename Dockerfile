# Étape 1 : Builder
FROM php:8.1-cli AS builder

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev && \
    docker-php-ext-install zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers de votre projet dans l'image
COPY . .

# Installer les dépendances avec Composer
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Étape 2 : Image finale (nommée final)
FROM php:8.1-fpm AS final

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers construits depuis l'étape "builder"
COPY --from=builder /app /var/www/html

# Exposer le port pour PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
