<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche par secteur d'activité</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Favicon -->
        <link href="img/logo aut.png" rel="icon">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: url('img/logo_aut_blurred (1).png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            margin: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #00abe4;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #00abe4;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #008bb3;
        }

        .resultat {
            border: 1px solid #ccc;
            background-color: #FFFFFF;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .resultat h3 {
            margin-top: 0;
        }

        .resultat p {
            margin: 5px 0;
        }

        .resultat a {
            color: #00abe4;
            text-decoration: none;
            font-weight: bold;
        }

        .resultat a:hover {
            text-decoration: underline;
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
    <div class="container">
        <header>
            <img src="img/logo aut.png" alt="Votre Logo" width="150">
        </header>
        <h1>Recherche par spécialité</h1>
        <form method="post" action="#">
            <div class="form-group">
                <label for="secteur_activité">Sélectionnez une spécialité :</label>
                <select name="secteur_activité" id="secteur_activité" class="form-control">
                    <?php
                    // Connexion à la base de données
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "resumerrpfa";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Récupérer les secteurs d'activité depuis la base de données
                    $sql = "SELECT DISTINCT secteur_activité FROM chercheuremploi";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["secteur_activité"] . "'>" . $row["secteur_activité"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucun secteur d'activité trouvé</option>";
                    }

                    // Fermer la connexion à la base de données
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Chercher</button>
        </form>

        <?php
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si le secteur d'activité a été sélectionné
            if (!empty($_POST["secteur_activité"])) {
                // Connexion à la base de données
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Récupérer les noms et prénoms des personnes dans le secteur d'activité sélectionné
                $secteur_activité= $_POST["secteur_activité"];
                $sql = "SELECT ID_chercheur, Nom, Prenom, Email, Numero_Tel FROM chercheuremploi WHERE secteur_activité = '$secteur_activité'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<h2>Résultats pour la spécialité : $secteur_activité</h2>";
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='resultat'>";
                        echo "<h3>" . $row["Prenom"] . " " . $row["Nom"] . "</h3>";
                        echo "<p>Email : " . $row["Email"] . "</p>";
                        echo "<p>Téléphone : " . $row["Numero_Tel"] . "</p>";
                        echo "<p><a href='profil_ch_ent.php?id=" . $row["ID_chercheur"] . "'>Voir profil</a></p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucun résultat trouvé pour la spécialité: $secteur_activité</p>";
                }

                // Fermer la connexion à la base de données
                $conn->close();
            } else {
                echo "<p>Veuillez sélectionner une spécialité.</p>";
            }
        }
        ?>
    
    </div>
    <footer>
    <a href="acceuilentreprise.html" class="back-link">&larr; Revenir à la page précédente</a>
</footer>
</body>
</html>