<?php
header("Content-Type: image/png"); // Définit le type MIME de l’image

// Chemin de l’image sur le serveur
$imagePath = "carte_identity.png";

// Vérifie si l’image existe et l’affiche
if (file_exists($imagePath)) {
    readfile($imagePath);
} else {
    http_response_code(404);
    echo "Image not found";
}
?>

