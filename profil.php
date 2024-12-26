<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès non autorisé");
}

// Connexion à la base de données
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur depuis la session
$id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur basé sur l'ID
$sql = "SELECT * FROM chercheuremploi WHERE ID_chercheur = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifiez si des résultats ont été trouvés
if ($result->num_rows > 0) {
    // Récupérer les informations de l'utilisateur
    $row = $result->fetch_assoc();
    $nom = $row["Nom"];
    $prenom = $row["Prenom"];
    $adresse = $row["Adresse"];
    $Numero_Tel = $row["Numero_Tel"];
    $email = $row["Email"];
    $cv = $row["CV_url"];
} else {
    echo "Aucun résultat trouvé pour ID: " . $id;
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de profil</title>
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
            animation: fadeIn 1s ease-in-out;
            width: 90%;
            max-width: 600px;
        }

        h2 {
            color: #00abe4;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #00abe4;
            box-shadow: 0 0 5px rgba(0, 171, 228, 0.5);
        }

        .btn-primary {
            background-color: #00abe4;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #008bb3;
            transform: scale(1.05);
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
        <h2>Profil de l'utilisateur</h2>
        <form action="modifierprofil.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group">
                <label>Nom:</label>
                <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
            </div>
            <div class="form-group">
                <label>Prénom:</label>
                <input type="text" class="form-control" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>">
            </div>
            <div class="form-group">
                <label>Adresse:</label>
                <input type="text" class="form-control" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>">
            </div>
            <div class="form-group">
                <label>Numéro de téléphone:</label>
                <input type="text" class="form-control" name="telephone" value="<?php echo htmlspecialchars($Numero_Tel); ?>">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="form-group">
                <label>CV:</label>
                <input type="text" class="form-control" name="cv" value="<?php echo htmlspecialchars($cv); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
    <footer>
        <a href="acceuilchercheur.html" class="back-link">&larr; Revenir à la page précédente</a>
    </footer>
</body>
</html>