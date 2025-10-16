# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Met à jour apt et installe les extensions PHP et outils nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql intl mbstring xml \
    && a2enmod rewrite

# Définir le répertoire de travail
WORKDIR /var/www/html/

# Copier les fichiers du projet
COPY . /var/www/html/

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances Symfony sans exécuter les scripts auto pour éviter symfony-cmd
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Vider le cache Symfony en production
RUN php bin/console cache:clear --env=prod

# Expose le port 80 pour Apache
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
