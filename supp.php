<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès non autorisé");
}

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';

// Connexion à la base de données
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_candidature = $_POST['id_candidature'];

    // Préparation de la requête de suppression
    $sql = "DELETE FROM candidature WHERE ID_candidature = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Préparation de la requête échouée : " . $conn->error);
    }
    $stmt->bind_param("i", $id_candidature);
    if (!$stmt->execute()) {
        die("Exécution de la requête échouée : " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();

// Rediriger vers la page des candidatures
header("Location: liste.php");
exit;
