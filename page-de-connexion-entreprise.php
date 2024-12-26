<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="img/logo aut.png" rel="icon">
    <title>Connexion Entreprise</title>
    <style>
        body {
            background-color: #E9F1FA;
            font-family: Arial, sans-serif;
            color: #050a30;
            text-align: center;
            padding-top: 50px;
        }
        h1 {
            color: #00ABE4;
        }
        label {
            display: inline-block;
            width: 120px; 
            text-align: right;
            margin-right: 20px;
            margin-bottom: 10px;
            color: #050a30;
        }
        input[type="email"],
        input[type="password"],
        button {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #00ABE4;
            width: 250px;
            box-sizing: border-box;
        }
        button {
            background-color: #00ABE4;
            color: #050a30;
            border: none;
            cursor: pointer;
        }
        a {
            color: #00ABE4;
            text-decoration: none;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo de votre entreprise" class="logo">
    <h1>Connexion Entreprise</h1>
    <form method="post" action="verifier-login-entreprise.php">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="inscription_entreprise.html">Créez-en un</a></p>
</body>
</html>
