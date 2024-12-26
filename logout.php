<?php
// Démarrez la session si ce n'est pas déjà fait
session_start();

// Détruisez toutes les variables de session
$_SESSION = array();

// Détruisez la session
session_destroy();

// Redirigez l'utilisateur vers la page de connexion
header("location: auto.html");
exit;
?>
