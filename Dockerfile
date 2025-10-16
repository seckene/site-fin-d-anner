# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires pour Symfony
RUN docker-php-ext-install pdo pdo_mysql

# Active mod_rewrite pour Symfony
RUN a2enmod rewrite

# Installe Git (nécessaire pour certains packages Composer)
RUN apt-get update && apt-get install -y git unzip

# Définit le répertoire de travail
WORKDIR /var/www/html/

# Copie les fichiers du projet dans le conteneur
COPY . /var/www/html/

# Installe Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installe les dépendances Symfony
RUN composer install --no-dev --optimize-autoloader

# Expose le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
