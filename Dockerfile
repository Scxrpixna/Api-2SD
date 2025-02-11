# Utilisation de l'image officielle PHP sans Apache
FROM php:8.1-cli

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers de l'API dans le conteneur
COPY . .

# Ouvrir le port 8000 (ou un autre si nécessaire)
EXPOSE 8000

# Lancer PHP en mode serveur intégré
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
