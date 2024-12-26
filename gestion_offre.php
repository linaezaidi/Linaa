<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resumerrpfa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Initialisation des variables de modification
$modifier = false;
$titre_a_modifier = "";
$id_offre_a_modifier = 0;
$lien_formation_a_modifier = "";

// Traitement du formulaire d'ajout d'offre d'emploi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $titre = $_POST["titre"];
    $secteur_activite = $_POST["secteur_activite"];
    $lien_formation = $_POST["lien_formation"];

    // Insérer l'offre d'emploi dans la base de données
    $sql = "INSERT INTO offre_emploi (Titre, ID_entreprise, Date_Publication, Lien_Formation)
            VALUES ('$titre', (SELECT ID_entreprise FROM entreprise LIMIT 1), NOW(), '$lien_formation')";
    if ($conn->query($sql) === TRUE) {
        echo "Offre d'emploi ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'offre d'emploi: " . $conn->error;
    }

    // Redirection après le traitement
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Traitement de la suppression d'une offre d'emploi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id_offre = $_POST["id_offre"];

    // Supprimer l'offre d'emploi de la base de données
    $sql = "DELETE FROM offre_emploi WHERE ID_offre='$id_offre'";
    if ($conn->query($sql) === TRUE) {
        echo "Offre d'emploi supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'offre d'emploi: " . $conn->error;
    }

    // Redirection après le traitement
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Préparation de la modification d'une offre d'emploi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id_offre = $_POST["id_offre"];

    // Récupérer les informations de l'offre d'emploi à modifier
    $sql = "SELECT Titre, Lien_Formation FROM offre_emploi WHERE ID_offre='$id_offre'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titre_a_modifier = $row["Titre"];
        $lien_formation_a_modifier = $row["Lien_Formation"];
        $id_offre_a_modifier = $id_offre;
        $modifier = true;
    }
}

// Traitement du formulaire de modification d'offre d'emploi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id_offre = $_POST["id_offre"];
    $titre = $_POST["titre"];
    $lien_formation = $_POST["lien_formation"];

    // Mettre à jour l'offre d'emploi dans la base de données
    $sql = "UPDATE offre_emploi SET Titre='$titre', Lien_Formation='$lien_formation' WHERE ID_offre='$id_offre'";
    if ($conn->query($sql) === TRUE) {
        echo "Offre d'emploi modifiée avec succès.";
    } else {
        echo "Erreur lors de la modification de l'offre d'emploi: " . $conn->error;
    }

    // Redirection après le traitement
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Récupérer les offres d'emploi depuis la base de données
$sql = "SELECT Titre, Date_Publication, ID_offre, Lien_Formation FROM offre_emploi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
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
            animation: fadeIn 1s ease-in-out;
        }

        .container {
            
            padding: 30px;
            border-radius: 8px;
            
            width: 90%;
            max-width: 1000px;
            margin: 20px;
        }

        h1, h2 {
            color: #050a30;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h1 {
            color: #00abe4;
        }

        .add-offer, .offers {
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            color: #333;
            margin-top: 0;
        }

        .card p {
            color: #666;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .actions form {
            display: inline;
        }

        input[type="text"], select {
            width: 60%;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="text"]:focus, select:focus {
            border-color: #00abe4;
            outline: none;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="submit"] {
            background-color: #00abe4;
            color: white;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.1em;
            text-transform: uppercase;
        }

        input[type="submit"]:hover {
            background-color: #008bb3;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #ff4c4c;
        }

        .btn-danger:hover {
            background-color: #cc0000;
        }

        .btn-warning {
            background-color: #ffcc00;
        }

        .btn-warning:hover {
            background-color: #e6b800;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
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
/* Bouton Ajouter */
input[type="submit"][name="submit"] {
    background-color: #00abe4; /* Couleur bleu clair */
    color: white;
    padding: 10px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 1.1em;
    text-transform: uppercase;
}

input[type="submit"][name="submit"]:hover {
    background-color: #008bb3;
    transform: scale(1.05);
}

/* Bouton Supprimer */
input[type="submit"][name="supprimer"], .btn-danger {
    background-color: #ff4c4c; /* Couleur rouge */
    color: white;
    padding: 10px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 1.1em;
    text-transform: uppercase;
}

input[type="submit"][name="supprimer"]:hover, .btn-danger:hover {
    background-color: #cc0000;
    transform: scale(1.05);
}

/* Bouton Modifier */
input[type="submit"][name="modifier"], .btn-warning {
    background-color: #4169e1; /* Couleur bleu roi */
    color: white;
    padding: 10px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 1.1em;
    text-transform: uppercase;
}

input[type="submit"][name="modifier"]:hover, .btn-warning:hover {
    background-color: #365fba;
    transform: scale(1.05);
}

    </style>
    <title>Gestion des Offres d'Emploi</title>
</head>
<body>
<div class="container">
    <h1>Gestion des Offres d'Emploi</h1>

    <div class="add-offer">
        <h2>Ajouter une Offre d'Emploi</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="titre">Titre:</label>
            <input type="text" name="titre" required>
            <label for="secteur_activite">Secteur d'Activité:</label>
            <select name="secteur_activite" required>
                <option value="Informatique">Informatique</option>
                <option value="Finance">Finance</option>
                <option value="Marketing">Marketing</option>
            </select>
            <label for="lien_formation">Lien de Formation:</label>
            <input type="text" name="lien_formation" required>
            <input type="submit" name="submit" value="Ajouter">
        </form>
    </div>

    <div class="offers">
        <h2>Offres d'Emploi Publiées</h2>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>" . $row["Titre"] . "</h3>";
                echo "<p>Date de Publication: " . $row["Date_Publication"] . "</p>";
                echo "<p>Lien de Formation: <a href='" . $row["Lien_Formation"] . "'>" . $row["Lien_Formation"] . "</a></p>";
                echo "<div class='actions'>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='form-inline'>
                            <input type='hidden' name='id_offre' value='" . $row["ID_offre"] . "'>
                            <input type='submit' name='supprimer' value='Supprimer' class='btn-danger'>
                        </form>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='form-inline'>
                            <input type='hidden' name='id_offre' value='" . $row["ID_offre"] . "'>
                            <input type='submit' name='modifier' value='Modifier' class='btn-warning'>
                        </form>
                      </div>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune offre d'emploi publiée.</p>";
        }
        ?>
    </div>

    <?php
    // Formulaire de modification d'offre d'emploi
    if ($modifier) {
        echo "<div class='update-offer'>
                <h2>Modifier l'Offre d'Emploi</h2>
                <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                    <label for='titre'>Titre:</label>
                    <input type='text' name='titre' value='$titre_a_modifier' required>
                    <label for='lien_formation'>Lien de Formation:</label>
                    <input type='text' name='lien_formation' value='$lien_formation_a_modifier' required>
                    <input type='hidden' name='id_offre' value='$id_offre_a_modifier'>
                    <input type='submit' name='update' value='Modifier'>
                </form>
              </div>";
    }
    ?>

</div>
<footer>
    <a href="acceuilentreprise.html" class="back-link">&larr; Revenir à la page précédente</a>
</footer>
</body>
</html>

<?php
$conn->close();
?>