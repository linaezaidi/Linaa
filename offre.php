<?php
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

// Récupérer les offres d'emploi
$sql = "SELECT ID_offre, Titre, Date_Publication FROM offre_emploi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'emploi</title>
    <link href="img/logo aut.png" rel="icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            max-width: 1000px;
            margin: 20px;
        }

        h1 {
            color: #00abe4;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            color: #00abe4;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #00abe4;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #008bb3;
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .container {
            animation: fadeIn 1s ease-in-out;
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
    <div class="container mt-5">
        <h1 class="mb-4">Offres d'emploi</h1>
        <?php
        if ($result->num_rows > 0) {
            // Afficher les offres d'emploi
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row["Titre"] . "</h5>";
                echo "<p class='card-text'><small class='text-muted'>Publiée le " . $row["Date_Publication"] . "</small></p>";
                // Bouton "Postuler" avec lien vers la page de candidature en passant l'ID de l'offre
                echo "<a href='candidature3.php?id=" . $row["ID_offre"] . "' class='btn btn-primary'>Postuler</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune offre d'emploi disponible pour le moment.</p>";
        }
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer>
    <a href="acceuilchercheur.html" class="back-link">&larr; Revenir à la page précédente</a>
    </footer>
</body>
</html>