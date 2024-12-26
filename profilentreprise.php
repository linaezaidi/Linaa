<?php
// profil.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resumerrpfa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the company ID is known, for example, from session or passed as a parameter
$ID_entreprise = 2; // Change this as needed

$sql = "SELECT Nom, description_entreprise FROM entreprise WHERE ID_entreprise=$ID_entreprise";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $nom = $row["Nom"];
        $description = $row["description_entreprise"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Entreprise</title>
</head>
<body>
    <h1>Profil de l'Entreprise</h1>
    <h2><?php echo $nom; ?></h2>
    <p><?php echo $description; ?></p>
</body>
</html>