// Fonction pour récupérer une variable depuis l'API
function getVariable(userId, key) {
  return new Promise((resolve, reject) => {
    fetch(`http://localhost:3000/api/get-variable?user_id=${userId}&key=${key}`)
      .then(response => response.json())
      .then(data => resolve(data.value))
      .catch(err => reject(err));
  });
}

// Fonction pour dessiner sur le canvas
async function drawCanvas(userId) {
  const canvas = document.getElementById('canvas');
  const ctx = canvas.getContext('2d');

  // Efface le canvas avant de dessiner
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Récupère et affiche les informations
  try {
      let prenom = await getVariable(userId, "prénom");
      let nom = await getVariable(userId, "nom");
      let ddn = await getVariable(userId, "ddn");
      
      ctx.font = '20px Arial';
      ctx.fillText(`Nom: ${nom}`, 50, 50);
      ctx.fillText(`Prénom: ${prenom}`, 50, 80);
      ctx.fillText(`Date de naissance: ${ddn}`, 50, 110);
  } catch (error) {
      console.error("Erreur lors de la récupération des données :", error);
  }
}

// Charger les infos du joueur sur le canvas
window.onload = function() {
  const userId = "12345";  // Remplace par l'ID de l'utilisateur concerné
  drawCanvas(userId);
};
