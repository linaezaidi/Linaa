<?php
// Récupérer les données du formulaire
$email = $_POST['Email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=resumerrpfa', 'root', '');

// Requête pour vérifier les données de connexion de l'entreprise
$query = $bdd->prepare('SELECT * FROM entreprise WHERE Email = :Email AND mot_de_passe = :mot_de_passe');
$query->execute(array(
    'Email' => $email,
    'mot_de_passe' => $mot_de_passe,
));

// Vérifier si l'utilisateur existe
if ($query->rowCount() > 0) {
    // Utilisateur trouvé, rediriger vers la page de succès
    header('Location: acceuilentreprise.html');
    
} else {
    // Utilisateur non trouvé, rediriger vers la page de connexion avec un message d'erreur
    header('Location: connexionentreprise.php?erreur=1');
}
?>
