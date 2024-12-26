<?php
// Récupérer les données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=resumerrpfa', 'root', '');

// Requête pour vérifier les données de connexion du chercheur d'emploi
$query = $bdd->prepare('SELECT * FROM chercheuremploi WHERE email = :email AND mot_de_passe = :password');
$query->execute(array(
    'email' => $email,
    'password' => $password
));

// Vérifier si l'utilisateur existe
if ($query->rowCount() > 0) {
    // Utilisateur trouvé, rediriger vers la page de succès
    header('Location: acceuilchercheur.html');
} else {
    // Utilisateur non trouvé, rediriger vers la page de connexion avec un message d'erreur
    header('Location: page-de-connexion-chercheur.php?erreur=1');
}
