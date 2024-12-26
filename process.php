<?php
$pdo = new PDO('mysql:host=localhost;dbname=resumerrpfa', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titre'])) {
    $titre = $_POST['titre'];
    $secteur_activite = $_POST['secteur_activite'];

    $stmt = $pdo->prepare("INSERT INTO Offre (Titre, Secteur_activite, Date_publication) VALUES (:titre, :secteur_activite, NOW())");
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':secteur_activite', $secteur_activite);
    $stmt->execute();

    header('Location: index.html'); // Assurez-vous que cette redirection est appropriée
    exit();
}

// Gestion de la suppression d'une offre
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['supprimer_id'])) {
    $id = $_GET['supprimer_id'];
    $stmt = $pdo->prepare("DELETE FROM Offre WHERE ID = ?");
    $stmt->execute([$id]);

    header('Location: index.html'); // Redirection
    exit();
}
?>
