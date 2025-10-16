FROM php:8.2-apache

# Extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Apache mod_rewrite
RUN a2enmod rewrite

# Installer git et unzip pour Composer
RUN apt-get update && apt-get install -y git unzip curl

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définir répertoire de travail
WORKDIR /var/www/html/

# Copier les fichiers du projet
COPY . /var/www/html/

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances Symfony
RUN composer install --no-dev --optimize-autoloader

# Clear cache prod
RUN php bin/console cache:clear --env=prod

# Expose port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
