<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resumerrpfa";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération du secteur d'activité depuis les paramètres GET
$secteuractivite = isset($_GET['secteuractivite']) ? $conn->real_escape_string($_GET['secteuractivite']) : '';

// Requête pour récupérer les entreprises correspondant au secteur d'activité
$sql = "SELECT Nom, Email FROM entreprise WHERE Secteur_activite = '$secteuractivite'";
$result = $conn->query($sql);

$entreprises = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entreprises[] = $row;
    }
}

// Fermeture de la connexion
$conn->close();

// Envoi des données en format JSON
header('Content-Type: application/json');
echo json_encode($entreprises);
?>
