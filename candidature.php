<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resumerrpfa";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si une action d'acceptation ou de refus a été envoyée
if (isset($_POST['action']) && isset($_POST['ID_candidature'])) {
    $ID_candidature = intval($_POST['ID_candidature']);
    $action = $_POST['action'];

    if ($action === 'accept') {
        $statut = 'accepté';
    } elseif ($action === 'refuse') {
        $statut = 'refusé';
    } else {
        $statut = 'en attente';
    }

    $stmt = $conn->prepare("UPDATE candidature SET Statut = ? WHERE ID_candidature = ?");
    $stmt->bind_param("si", $statut, $ID_candidature);
    $stmt->execute();
    $stmt->close();
}

// Récupérer les candidatures de la base de données
$sql = "SELECT c.ID_candidature, ce.Nom, ce.Prenom, c.ID_offre, c.Statut, c.Date_soumission 
        FROM candidature c
        JOIN chercheuremploi ce ON c.ID_chercheur = ce.ID_chercheur";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des candidatures</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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

        h1 {
            color: #00abe4;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #00abe4;
            color: white;
        }

        .btn-accept {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-accept:hover {
            background-color: #218838;
        }

        .btn-refuse {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-refuse:hover {
            background-color: #c82333;
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
        
        <h1>Liste des candidatures</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Candidature</th>
                    <th>Nom et Prénom</th>
                    <th>ID Offre</th>
                    <th>Statut</th>
                    <th>Date de Soumission</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['ID_candidature']; ?></td>
                    <td><?php echo $row['Nom'] . ' ' . $row['Prenom']; ?></td>
                    <td><?php echo $row['ID_offre']; ?></td>
                    <td><?php echo $row['Statut']; ?></td>
                    <td><?php echo $row['Date_soumission']; ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="ID_candidature" value="<?php echo $row['ID_candidature']; ?>">
                            <button type="submit" name="action" value="accept" class="btn-accept">Accepter</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="ID_candidature" value="<?php echo $row['ID_candidature']; ?>">
                            <button type="submit" name="action" value="refuse" class="btn-refuse">Refuser</button>
                        </form>
                        
                    </td>
                </tr>
                
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <footer>
    <a href="acceuilentreprise.html" class="back-link">&larr; Revenir à la page précédente</a>
    </footer>
</body>
</html>

<?php
$conn->close();
?>