<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de profil</title>
        <!-- Favicon -->
        <link href="img/logo aut.png" rel="icon">
    <style>
        /* Style de base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('img/logo_aut_blurred (1).png') no-repeat center center fixed; /* Image de fond */
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out, slideIn 0.8s ease-in-out;
        }

        h1, h2 {
            color: #00abe4; /* Bleu pour les titres */
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        p {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background: #f9f9f9;
            color: #333;
            font-weight: normal;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        /* Boutons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.1em;
            text-transform: uppercase;
            color: white;
        }

        .btn-ajouter {
            background: #4CAF50; /* Vert professionnel */
        }
        .btn-ajouter:hover {
            background: #45A049;
            transform: scale(1.05);
        }

        .btn-supprimer {
            background: #F44336; /* Rouge professionnel */
        }
        .btn-supprimer:hover {
            background: #D32F2F;
            transform: scale(1.05);
        }

        .btn-modifier {
            background: #2196F3; /* Bleu professionnel */
        }
        .btn-modifier:hover {
            background: #1976D2;
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        .slide-in {
            animation: slideIn 0.8s ease-in-out;
        }
        footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: left;
    padding: 10px;
}

.back-link {
    text-decoration: none;
    color: #bleu;
    font-weight: bold;
}

.back-link:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>
    <div class="container fade-in slide-in">
        <h1>Profil du chercheur d'emploi</h1>
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "resumerrpfa";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }

        // Requête SQL pour récupérer les informations du chercheur d'emploi
        // Récupérer l'ID du chercheur depuis l'URL
        if(isset($_GET["id"])) {
            $id_chercheur = $_GET["id"];

            // Connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Récupérer les informations du chercheur
            $sql = "SELECT * FROM chercheuremploi WHERE ID_chercheur = $id_chercheur";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Afficher les informations du chercheur
                while($row = $result->fetch_assoc()) {
                    echo "<h2>Profil de " . $row["Prenom"] . " " . $row["Nom"] . "</h2>";
                    echo "<div class='profile-info'>";
                    echo "<p><label>Nom :</label> " . $row["Nom"] . "</p>";
                    echo "<p><label>Prénom :</label> " . $row["Prenom"] . "</p>";
                    echo "<p><label>Adresse :</label> " . $row["Adresse"] . "</p>";
                    echo "<p><label>Numéro de téléphone :</label> " . $row["Numero_Tel"] . "</p>";
                    echo "<p><label>Email :</label> " . $row["Email"] . "</p>";
                    echo "<p><label>Secteur d'activité :</label> " . $row["secteur_activité"] . "</p>";
                    echo "</div>";
                    // Ajoutez le code pour afficher le CV si nécessaire
                }
            } else {
                echo "<p>Aucun profil trouvé pour cet ID.</p>";
            }

            // Fermer la connexion à la base de données
            $conn->close();
        } else {
            echo "<p>Aucun ID de chercheur spécifié.</p>";
        }
        ?>
    </div>
    <footer>
    <a href="rechercher_en_fct_sp.php" class="back-link">&larr; Revenir à la page précédente</a>
</footer>
</body>
</html>
