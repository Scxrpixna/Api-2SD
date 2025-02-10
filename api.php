<?php
// Vérifier si tous les paramètres sont présents
if (!isset($_GET['nom']) || 
    !isset($_GET['prenom']) || 
    !isset($_GET['lieu_naissance']) || 
    !isset($_GET['date_naissance']) || 
    !isset($_GET['date_delivrance']) || 
    !isset($_GET['taille']) || 
    !isset($_GET['sexe']) || 
    !isset($_GET['id']) || 
    !isset($_GET['avatar'])) {
    header('Content-Type: text/plain');
    echo 'Tous les paramètres (nom, prenom, lieu_naissance, date_naissance, date_delivrance, taille, sexe, id, avatar) sont requis.';
    exit;
}

// Récupérer et sécuriser les paramètres
$nom = htmlspecialchars($_GET['nom']);
$prenom = htmlspecialchars($_GET['prenom']);
$lieu_naissance = htmlspecialchars($_GET['lieu_naissance']);
$date_naissance = htmlspecialchars($_GET['date_naissance']);
$date_delivrance = htmlspecialchars($_GET['date_delivrance']);
$taille = htmlspecialchars($_GET['taille']);
$sexe = htmlspecialchars($_GET['sexe']);
$id = htmlspecialchars($_GET['id']);
$avatar_url = filter_var($_GET['avatar'], FILTER_VALIDATE_URL);

// Vérifier si l'URL de l'avatar est valide et termine par .png
if (!$avatar_url || !str_ends_with($avatar_url, '.png')) {
    header('Content-Type: text/plain');
    echo 'Le paramètre avatar doit être un lien valide vers une image PNG.';
    exit;
}

// Charger l'image de fond
$background_path = __DIR__ . '/carte_identity.png';
$background = @imagecreatefrompng($background_path);
if ($background === false) {
    header('Content-Type: text/plain');
    echo 'Erreur lors du chargement de l\'image de fond. Assurez-vous que le fichier carte_identity.png est présent à la racine.';
    exit;
}

// Charger l'avatar
$avatar = @imagecreatefrompng($avatar_url);
if ($avatar === false) {
    header('Content-Type: text/plain');
    echo 'Impossible de charger l\'image de l\'avatar. Vérifiez le lien.';
    exit;
}

// Redimensionner les images
$background_resized = imagescale($background, 1689 / 2, 1080 / 2);
$avatar_resized = imagescale($avatar, 180, 220);
imagedestroy($background);
imagedestroy($avatar);

// Créer l'image principale avec transparence
$image = imagecreatetruecolor(844, 540);
imagesavealpha($image, true);
$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127); // Couleur transparente
imagefill($image, 0, 0, $transparent);

// Copier l'image de fond sur l'image principale
imagecopy($image, $background_resized, 0, 0, 0, 0, 844, 540);
imagedestroy($background_resized);

// Copier l'avatar sur l'image principale
imagecopy($image, $avatar_resized, 50, 147, 0, 0, 180, 220);
imagedestroy($avatar_resized);

// Définir une couleur de texte (noir)
$noir = imagecolorallocate($image, 0, 0, 0);

// Charger la police
$font = __DIR__ . '/arial.ttf';
if (!file_exists($font)) {
    header('Content-Type: text/plain');
    echo 'Police non trouvée : arial.ttf. Ajoutez ce fichier dans le répertoire.';
    exit;
}
$size = 20;

// Définir les couleurs pour le texte
$rouge = imagecolorallocate($image, 4, 9, 71); // Rouge pour les labels

// Ajouter les labels
imagettftext($image, $size, 0, 250, 179, $rouge, $font, "NOM:");
imagettftext($image, $size, 0, 250, 234, $rouge, $font, "PNM:");
imagettftext($image, $size, 0, 250, 284, $rouge, $font, "LDN:");
imagettftext($image, $size, 0, 570, 109, $rouge, $font, "DDN:");
imagettftext($image, $size, 0, 570, 399, $rouge, $font, "DEL:");
imagettftext($image, $size, 0, 250, 339, $rouge, $font, "TIE:");
imagettftext($image, $size, 0, 674, 154, $rouge, $font, "SEX:");
imagettftext($image, $size, 0, 380, 479, $rouge, $font, "ID:");

// Ajouter les valeurs des variables
imagettftext($image, $size, 0, 330, 180, $noir, $font, $nom);
imagettftext($image, $size, 0, 330, 235, $noir, $font, $prenom);
imagettftext($image, $size, 0, 330, 285, $noir, $font, $lieu_naissance);
imagettftext($image, $size, 0, 650, 110, $noir, $font, $date_naissance);
imagettftext($image, $size, 0, 640, 400, $noir, $font, $date_delivrance);
imagettftext($image, $size, 0, 330, 340, $noir, $font, $taille);
imagettftext($image, $size, 0, 750, 155, $noir, $font, $sexe);
imagettftext($image, $size, 0, 420, 480, $noir, $font, $id);

// Envoyer l'image avec transparence
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
