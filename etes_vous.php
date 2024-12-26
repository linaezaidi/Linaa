<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix</title>
    <style>
        body {
            background-color: #E9F1FA;
            font-family: Arial, sans-serif;
            color: #050a30;
            text-align: center;
            padding-top: 50px;
        }
        button {
            background-color: #00ABE4;
            color: #050a30;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Veuillez choisir :</h1>
    <button onclick="redirectTo('entreprise')">Entreprise</button>
    <button onclick="redirectTo('chercheur')">Chercheur d'emploi</button>

    <script>
        function redirectTo(type) {
            if (type === 'entreprise') {
                window.location.href = 'entreprise.html';
            } else if (type === 'chercheur') {
                window.location.href = 'chercheur.html';
            }
        }
    </script>
</body>
</html>
