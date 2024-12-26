<?php
session_start(); // Démarrer la session

// Connexion à la base de données
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement du formulaire de candidature
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $offre_id = $_POST['offre_id']; // Nouveau champ pour récupérer l'ID de l'offre sélectionnée

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        // Traitement du fichier CV
    } else {
        echo "Veuillez télécharger votre CV.";
    }
}

// Récupérer l'ID du chercheur à partir de la session PHP
if(isset($_SESSION['user_id'])){
    $id_chercheur = $_SESSION['user_id'];
}else{
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: coonexionchercheur.php");
    exit;
}

$sql_offres = "SELECT ID_offre, Titre FROM offre_emploi";
$result_offres = $conn->query($sql_offres);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <title>Candidature</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            color: #00abe4;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        select, input[type="file"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            transition: all 0.3s ease;
        }

        input[type="submit"] {
            background-color: #00abe4;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #008bb3;
            transform: scale(1.05);
        }

        select:focus, input[type="file"]:focus, input[type="submit"]:focus {
            outline: none;
            border-color: #00abe4;
            box-shadow: 0 0 5px rgba(0, 171, 228, 0.5);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
    color: #000000;
    font-weight: bold;
}

.back-link:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Postuler à une offre d'emploi</h1>
        <form action="postuler.php" method="post" enctype="multipart/form-data">
        
            <!-- Utiliser l'ID du chercheur récupéré depuis la session -->
            <input type="hidden" name="id_chercheur" value="<?php echo $id_chercheur; ?>">

            <label for="offre_id">Choisir une offre :</label>
            <select name="offre_id" id="offre_id" required>
                <?php while ($row = $result_offres->fetch_assoc()) : ?>
                    <option value="<?php echo $row['ID_offre']; ?>"><?php echo $row['Titre']; ?></option>
                <?php endwhile; ?>
            </select>
            

            <label for="cv">CV (format PDF) :</label>
            <input type="file" name="cv" id="cv" accept=".pdf" required>

            <input type="submit" name="submit" value="Postuler">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <footer>
        <a href="offre.php" class="back-link">&larr; Revenir à la page précédente</a>
        </footer>
</body>
</html>