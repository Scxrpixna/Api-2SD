const express = require('express');
const { createCanvas, loadImage } = require('canvas');

const app = express();
const PORT = 3000; // Change ce port si nécessaire

// Route pour générer une carte d'identité
app.get('/api/carte', async (req, res) => {
    try {
        // Récupération des paramètres GET
        const nom = req.query.nom || 'Nom inconnu';
        const prenom = req.query.prenom || 'Prénom inconnu';
        const lieuNaissance = req.query.lieu_naissance || 'Inconnu';
        const dateNaissance = req.query.date_naissance || '00/00/0000';
        const dateDelivrance = req.query.date_delivrance || '00/00/0000';
        const taille = req.query.taille || '??? cm';
        const sexe = req.query.sexe || '?';
        const id = req.query.id || 'ID-0000';
        const avatarUrl = req.query.avatar || 'https://i.postimg.cc/cHTj3JcT/Sans-titre-1.png';

        // Création du canvas
        const largeur = 600;
        const hauteur = 400;
        const canvas = createCanvas(largeur, hauteur);
        const ctx = canvas.getContext('2d');

        // Fond blanc
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, largeur, hauteur);

        // Charger une image de fond (optionnel)
        const background = await loadImage('https://i.postimg.cc/cHTj3JcT/Sans-titre-1.png'); // Change pour ton propre fond
        ctx.drawImage(background, 0, 0, largeur, hauteur);

        // Charger et insérer l’avatar
        const avatar = await loadImage(avatarUrl);
        ctx.drawImage(avatar, 20, 50, 100, 100);

        // Style du texte
        ctx.fillStyle = '#000000';
        ctx.font = '20px Arial';

        // Ajouter du texte
        ctx.fillText(`Nom : ${nom}`, 140, 50);
        ctx.fillText(`Prénom : ${prenom}`, 140, 80);
        ctx.fillText(`Lieu de naissance : ${lieuNaissance}`, 140, 110);
        ctx.fillText(`Date de naissance : ${dateNaissance}`, 140, 140);
        ctx.fillText(`Délivrée le : ${dateDelivrance}`, 140, 170);
        ctx.fillText(`Taille : ${taille}`, 140, 200);
        ctx.fillText(`Sexe : ${sexe}`, 140, 230);
        ctx.fillText(`ID : ${id}`, 140, 260);

        // Convertir en image et envoyer la réponse
        res.setHeader('Content-Type', 'image/png');
        canvas.toBuffer((err, buffer) => {
            if (err) throw err;
            res.send(buffer);
        });
    } catch (error) {
        res.status(500).send({ error: 'Erreur lors de la génération de la carte.' });
    }
});

// Démarrer le serveur
app.listen(PORT, () => {
    console.log(`Serveur démarré sur http://localhost:${PORT}`);
});
