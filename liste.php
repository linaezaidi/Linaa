<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Accès non autorisé");
}

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';

// Connexion à la base de données
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$id = $_SESSION['user_id'];

// Récupération des candidatures de l'utilisateur connecté
$sql = "SELECT * FROM candidature WHERE ID_chercheur = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Préparation de la requête échouée : " . $conn->error);
}
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Exécution de la requête échouée : " . $stmt->error);
}
$result = $stmt->get_result();

// Stocker les résultats dans un tableau
$candidatures = [];
if ($result->num_rows > 0) {
    $candidatures = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Aucune candidature trouvée pour l'utilisateur avec ID: " . htmlspecialchars($id);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Candidatures</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link href="img/logo aut.png" rel="icon">
    <style>
        body {
            background: url('img/logo_aut_blurred (1).png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        .table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            background: #ffffff; /* White background for the table */
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 15px;
            border: 1px solid #00ABE4; /* Bright blue borders */
        }
        .table th {
            background: linear-gradient(45deg, #00ABE4, #00ABE4); /* Gradient from bright blue to light blue */
            color: white;
            text-align: center;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: #E9F1FA; /* Light blue for odd rows */
        }
        .table tbody tr:hover {
            background-color: #d4ebf9; /* Slightly darker light blue for hover effect */
        }
        .table td {
            transition: background-color 0.3s ease;
        }
        .btn-danger {
            background-color: #c01b2b; /* Dark red for button */
            border-color: #c01b2b;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-danger:hover {
            background-color: #a61c2e; /* Darker red on hover */
            transform: scale(1.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #050a30;
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
        <h1 class="title">Liste de Mes Candidatures</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID Candidature</th>
                    <th>ID Chercheur</th>
                    <th>ID Offre</th>
                    <th>Statut</th>
                    <th>Date de Soumission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($candidatures)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucune candidature trouvée.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($candidatures as $candidature): ?>
                        <tr>
                            <td><?= htmlspecialchars($candidature['ID_candidature']) ?></td>
                            <td><?= htmlspecialchars($candidature['ID_chercheur']) ?></td>
                            <td><?= htmlspecialchars($candidature['ID_offre']) ?></td>
                            <td><?= htmlspecialchars($candidature['Statut']) ?></td>
                            <td><?= htmlspecialchars($candidature['Date_soumission']) ?></td>
                            <td>
                                <form method="post" action="supp.php">
                                    <input type="hidden" name="id_candidature" value="<?= htmlspecialchars($candidature['ID_candidature']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Inclusion de Bootstrap JS et de ses dépendances -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <footer>
        <a href="acceuilchercheur.html" class="back-link">&larr; Revenir à la page précédente</a>
    </footer>
</body>
</html>