# Utiliser l'image PHP officielle
FROM php:8.3-cli

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers dans le conteneur
COPY . /app

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Installer les dépendances PHP
RUN composer install --ignore-platform-reqs

# Exposer un port
EXPOSE 8080

# Démarrer le serveur PHP
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]

