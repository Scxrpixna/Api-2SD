# Utilisation de l'image officielle PHP en mode CLI
FROM php:8.1-cli

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers de l'API dans le conteneur
COPY . .

# Installer les dépendances si ton projet utilise Composer
RUN if [ -f "composer.json" ]; then php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && php composer.phar install; fi

# Exposer le port utilisé par PHP
EXPOSE 8000

# Lancer le serveur PHP en utilisant la variable d'environnement $PORT
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8000} -t ."]





