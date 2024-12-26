<?php
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

// Récupérer les informations du formulaire
$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$numero_tel = $_POST['telephone'];
$email = $_POST['email'];
$cv = $_POST['cv'];

// Vérifiez si l'ID existe
$check_sql = "SELECT * FROM chercheuremploi WHERE ID_chercheur = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    die("ID non trouvé.");
}

// Mise à jour des informations du chercheur
$sql = "UPDATE chercheuremploi SET Nom = ?, Prenom = ?, Adresse = ?, Numero_Tel = ?, Email = ?, CV_url = ? WHERE ID_chercheur = ?";
$stmt = $conn->prepare($sql);

// Vérifier si la préparation de la requête a échoué
if (!$stmt) {
    die("Erreur de préparation de la requête: " . $conn->error);
}

// Liaison des paramètres
$stmt->bind_param("ssssssi", $nom, $prenom, $adresse, $numero_tel, $email, $cv, $id);

// Exécution de la requête
$stmt->execute();

// Vérifier si la mise à jour a réussi
if ($stmt->affected_rows > 0) {
    echo "<script>alert('Mise à jour réussie. !!'); window.location.href='acceuilchercheur.html';</script>";
} else {
    echo  "<script>alert('Erreur de Mise à jour .!!!'); window.location.href='acceuilchercheur.html';</script>";
}

// Fermeture de la connexion
$conn->close();
?>