<!DOCTYPE html>
<html>
<head>
    <title>Résultats de la Recherche d'Emplois</title>
</head>
<body>
    <h2>Résultats de la Recherche d'Emplois</h2>
    <?php
    // Récupérer le secteur d'activité choisi
    $Secteur_activite = $_GET["secteur_activite"];

    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=resumerrpfa", "root", "");

    // Requête pour récupérer les offres d'emploi du secteur d'activité choisi
    $stmt = $conn->prepare("SELECT * FROM offre_emploi WHERE Secteur_activite = :Secteur_activite");
    $stmt->bindParam(':secteur_activite', $Secteur_activite);
    $stmt->execute();
    $resultats = $stmt->fetchAll();

    // Afficher les offres d'emploi
    foreach ($resultats as $resultat) {
        echo "<p>Titre : " . $resultat['titre'] . "<br>";
        echo "Description : " . $resultat['description'] . "<br>";
        echo "Salaire : " . $resultat['salaire'] . "</p>";
    }
    ?>
</body>
</html>
