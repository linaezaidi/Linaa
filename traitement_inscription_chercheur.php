<?php
// Informations de connexion à la base de données
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numero_tel = $_POST["numero_tel"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $secteur_activite = $_POST["secteur_activite"];

    // Hasher le mot de passe pour la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer et lier la déclaration
    $stmt = $conn->prepare("INSERT INTO chercheuremploi (Nom, Prenom, Adresse, Numero_Tel, Email, Password, secteur_activité) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nom, $prenom, $adresse, $numero_tel, $email, $hashed_password, $secteur_activite);

    // Exécuter la déclaration
    if ($stmt->execute()) {
        // Inscription réussie, rediriger vers la page d'accueil
        echo "<script>window.location.href='acceuilchercheur.html';</script>";
        exit;
    } else {
        // Une erreur s'est produite, rediriger vers la page d'inscription avec un message d'erreur
        echo "<script>alert('Erreur lors de l\'inscription.'); window.location.href='register.html';</script>";
        exit;
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
mysqli_close($conn);
?>
