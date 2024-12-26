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

// Requête pour récupérer les secteurs d'activité
$sql = "SELECT DISTINCT Secteur_activite FROM entreprise";
$result = $conn->query($sql);

$secteur = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $secteur[] = $row['Secteur_activite'];
    }
}

// Fermeture de la connexion
$conn->close();

// Envoi des données en format JSON
header('Content-Type: application/json');
echo json_encode($secteur);
?>
