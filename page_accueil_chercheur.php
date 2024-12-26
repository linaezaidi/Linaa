<!DOCTYPE html>
<html>
<head>
    <title>Accueil Chercheur d'Emploi</title>
</head>
<body>
    <h2>Bienvenue sur votre page d'accueil</h2>
    <form action="rechercher_emplois.php" method="get">
        <label for="secteur_activite">Choisissez un secteur d'activité :</label>
        <select id="secteur_activite" name="secteur_activite">
            <option value="IT">IT</option>
            <option value="Finance">Finance</option>
            <option value="Santé">Santé</option>
            <!-- Ajoutez d'autres options selon vos besoins -->
        </select>
        <button onclick="window.location.href='resultat_recherche.php'">Rechercher</button>
    </form>
    <button onclick="window.location.href='gerer_candidatures.php'">Gérer les candidatures</button>
</body>
</html>
