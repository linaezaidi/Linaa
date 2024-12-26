<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "resumerrpfa");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Préparer et exécuter la requête
    $stmt = $conn->prepare("SELECT * FROM entreprise WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe dans la base de données
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Comparer le mot de passe saisi avec le hash stocké en base de données
        if (password_verify($password, $row['Password'])) {
            // Authentification réussie
            $_SESSION['email'] = $email;
            header('Location: acceuilentreprise.html');
            exit;
        } else {
            // Mot de passe incorrect
            $error = "Email ou mot de passe incorrect";
        }
    } else {
        // Utilisateur non trouvé
        $error = "Email ou mot de passe incorrect";
    }

    $stmt->close();
    $conn->close();
}
?>