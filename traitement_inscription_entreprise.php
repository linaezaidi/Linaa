<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'resumerrpfa';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["nom"];
    $email = $_POST["email"];
   
    $password = $_POST["mot_de_passe"];
    $confirm_password = $_POST["confirmation_mot_de_passe"];
    $secteur_activite = $_POST["secteur_activite"];
    $raison_sociale = $_POST["raison_sociale"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: acceuilentreprise.html?error=PasswordMismatch");
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO Entreprise (Nom, Email, Secteur_activite, Raison_sociale, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email,  $secteur_activite, $raison_sociale, $hashed_password);

    // Execute the statement    
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: acceuilentreprise.html");
        exit;
    } else {
        // Error occurred, redirect back to registration page with error message
        header("Location: register.html?error=RegistrationError");
        exit;
    }

    // Close statement
    $stmt->close();
}

mysqli_close($conn);
?>
