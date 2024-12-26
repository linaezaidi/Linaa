<?php
// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=resumerrpfa', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // Afficher les offres d'emploi existantes
    echo '<h2>Offres d\'emploi existantes</h2>';
    $query = $bdd->query('SELECT * FROM offre_emploi');
    while ($row = $query->fetch()) {
        echo '<p>' . $row['Titre'] . ' - Date de publication : ' . $row['Date_publication'] . ' <a href="process.php?supprimer=' . $row['ID_Offre'] . '">Supprimer</a></p>';
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
