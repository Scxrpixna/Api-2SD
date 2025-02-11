# Utilisation de PHP en mode CLI (sans Apache)
FROM php:8.1-cli

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers dans le conteneur
COPY . .

# Vérifier le port utilisé par Railway
RUN echo "Le serveur PHP va démarrer sur le port \$PORT"

# Lancer le serveur PHP intégré en écoutant le port défini par Railway
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t /var/www/html"]






