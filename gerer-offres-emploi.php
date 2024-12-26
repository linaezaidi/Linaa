<!DOCTYPE html>
<html>
<head>
    <title>Gérer les offres d'emploi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #E9F1FA; /* Light blue */
            color: #050a30; /* Dark blue */
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff; /* White */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #007bff; /* Bright blue */
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #007bff; /* Bright blue */
            color: #fff; /* White */
        }
        header img {
            height: 40px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
            margin-right: 20px;
            font-weight: bold;
        }
        input[type="text"],
        select {
            width: 300px;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #00ABE4; /* Bright blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            margin-bottom: 5px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <!-- Favicon -->
    <link href="img/logo aut.png" rel="icon">
        <h1>Gérer les offres d'emploi</h1>
        <img src="votre-logo.png" alt="Logo de votre entreprise">
    </header>
    <div class="container">
        <!-- Formulaire pour lancer une nouvelle offre d'emploi -->
        <h2>Lancer une nouvelle offre d'emploi</h2>
        <form method="post" action="">
            <label for="Titre">Titre de l'offre :</label>
            <input type="text" id="Titre" name="Titre" required><br><br>
            <label for="secteurActivite">Sélectionnez un secteur d'activité :</label>
            <select id="secteurActivite" name="secteurActivite" required>
                <option value="informatique">Informatique</option>
                <option value="finance">Finance</option>
                <option value="marketing">Marketing</option>
                <!-- Ajoutez d'autres options ici -->
            </select><br><br>
            <button type="submit" name="lancerOffre">Lancer l'offre</button>
        </form>


    <?php
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=resumerrpfa', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // Si le formulaire pour lancer une offre est soumis
    if (isset($_POST['lancerOffre'])) {
        // Récupérer les données du formulaire
        $titre = $_POST['Titre'];
        

        // Requête pour ajouter l'offre d'emploi à la base de données
        $query = $bdd->prepare('INSERT INTO offre_emploi (Titre,  Date_publication) VALUES (:Titre,  NOW())');
        $query->execute(array('Titre' => $titre));

        // Rafraîchir la page pour afficher la nouvelle offre ajoutée
        header('Location: gerer-offres-emploi.php');
        exit;
    }

    // Si une offre d'emploi doit être supprimée
    if (isset($_GET['supprimer'])) {
        // Récupérer l'ID de l'offre à supprimer
        $idOffre = $_GET['supprimer'];

        // Requête pour supprimer l'offre d'emploi de la base de données
        $query = $bdd->prepare('DELETE FROM offre_emploi WHERE ID_Offre= :ID_Offre');
        $query->bindValue(':ID_Offre', $idOffre, PDO::PARAM_INT);
        $query->execute();


        // Rafraîchir la page pour refléter la suppression de l'offre
        header('Location: gerer-offres-emploi.php');
        exit;
    }

    // Afficher les offres d'emploi existantes
    echo '<h2>Offres d\'emploi existantes</h2>';
    $query = $bdd->query('SELECT * FROM offre_emploi');
    while ($row = $query->fetch()) {
        echo '<p>' . $row['Titre'] . ' - Date_de_publication : ' . $row['Date_publication'] . ' <a href="?supprimer=' . $row['ID_Offre'] . '">Supprimer</a></p>';
    }

    // Fermer la connexion à la base de données
    $bdd = null;
    ?>
</body>
</html>
