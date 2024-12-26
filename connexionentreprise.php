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
    $stmt = $conn->prepare("SELECT ID_entreprise, Password FROM entreprise WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_entreprise, $password_hash);
        $stmt->fetch();
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // Comparer le hash du mot de passe saisi avec le hash stocké en base de données
        if (password_verify($password, $password_hash)) {
            $_SESSION['Email'] = $email;
            $_SESSION['ID_entreprise'] = $id_entreprise;
            header('Location: acceuilentreprise.html');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    } else {
        $error = "Email ou mot de passe incorrect";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="img/logo aut.png" rel="icon">
    <title>Connexion entreprise </title>
    <style>
        body {
            background-image: url('img/travail2_less_blur.png'); /* Utilisez le chemin de votre image floutée */
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #050a30;
            text-align: center;
            padding-top: 50px;
            overflow: hidden;
            animation: fadeInBackground 3s ease-in-out;
        }
        h1 {
            color: #00ABE4;
            margin-bottom: 30px; /* Réduire l'espace sous le titre */
            font-size: 2em; /* Taille de police modérée pour le titre */
            animation: fadeIn 1s ease-in-out;
        }
        form {
            display: inline-block;
            text-align: left;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 25px; /* Taille modérée pour le padding */
            border-radius: 10px; /* Arrondir légèrement les coins */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Ombre douce */
            animation: slideIn 1s ease-in-out 0.5s backwards;
            width: 350px; /* Largeur modérée du formulaire */
        }
        label {
            display: block;
            font-size: 1.1em; /* Taille de police modérée pour les labels */
            margin-bottom: 10px;
            color: #050a30;
            animation: fadeIn 1s ease-in-out 0.5s backwards;
        }
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #00ABE4;
            width: 100%;
            box-sizing: border-box;
            transition: box-shadow 0.3s, transform 0.3s;
            font-size: 1em;
            animation: fadeIn 1s ease-in-out 0.6s backwards;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            box-shadow: 0 0 10px #00ABE4;
            transform: scale(1.02);
        }
        .button-container {
            text-align: center;
        }
        button {
            background-color: #00ABE4;
            color: #050a30;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            animation: fadeIn 1s ease-in-out 0.7s backwards;
            font-size: 1em; /* Taille de police modérée pour le bouton */
        }
        button:hover {
            background-color: #007aae;
            transform: scale(1.05);
        }
        a {
            color: #00ABE4;
            text-decoration: none;
            animation: fadeIn 1s ease-in-out 0.9s backwards;
        }
        a:hover {
            color: #007aae;
        }
        .logo {
            max-width: 150px; /* Taille modérée pour le logo */
            margin-bottom: 20px; /* Espace sous le logo */
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            0% { opacity: 0; transform: translateX(-100px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInBackground {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <img src="img/logo aut.png" alt="Logo de votre entreprise" class="logo">
    <h1>Connexion entreprise </h1>
    <form method="post" action="">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>
        <div class="button-container">
            <button type="submit">Se connecter</button>
        </div>
    </form>
    <p>Vous n'avez pas de compte ? <a href="inscriptionentreprise.html">Créez-en un</a></p>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
