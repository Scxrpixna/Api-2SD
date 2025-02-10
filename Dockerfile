# Utiliser une image PHP avec support GD
FROM php:8.1-apache

# Activer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'API dans le conteneur
COPY . /var/www/html/

# Donner les bons droits
RUN chmod -R 755 /var/www/html

# Exposer le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
