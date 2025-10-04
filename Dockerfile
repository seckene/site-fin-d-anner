# Étape 1 : base PHP + Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires à Symfony
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip curl \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql opcache

# Activer mod_rewrite (routes Symfony)
RUN a2enmod rewrite

# Copier le projet dans le container
WORKDIR /var/www/html
COPY . .

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP via Composer sans auto-scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Exécuter manuellement les commandes importantes de Symfony
RUN php bin/console cache:clear --env=prod
RUN php bin/console assets:install public

# Préparer cache et logs
RUN mkdir -p var/cache var/log && chmod -R 777 var

# Configurer Apache pour que la racine web soit le dossier 'public'
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
