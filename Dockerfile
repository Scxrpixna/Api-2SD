# Utilise l'image PHP officielle
FROM php:8.3-cli

# Configure le répertoire de travail
WORKDIR /app

# Copie les fichiers de ton projet dans le conteneur
COPY . /app

# Installe Composer (gestionnaire de dépendances PHP)
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Expose le port 80
EXPOSE 80

# Lancer le serveur PHP avec le port configuré par Railway
CMD php -S 0.0.0.0:$PORT -t .
