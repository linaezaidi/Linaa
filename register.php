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
    $name = $_POST["name"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $numero_tel = $_POST["numero_tel"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sec = $_POST["sec"];
   
    
    session_start();
    $cvDir = 'Cherrcheur/cv_doss/';
    $cvFile = $cvDir . 'cv.pdf';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['cvFile']) && $_FILES['cvFile']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['cvFile']['tmp_name'];
            $fileName = 'cv.pdf';
            $fileDestPath = $cvDir . $fileName;
            
            // Créez le dossier s'il n'existe pas
            if (!is_dir($cvDir)) {
                mkdir($cvDir, 0777, true);
            }
    
            // Déplacez le fichier téléchargé vers le dossier de destination
            if (move_uploaded_file($fileTmpPath, $fileDestPath)) {
                header('Location: register.php');
            } else {
                echo 'Erreur lors du téléchargement du fichier.';
            }
        } elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
            if (file_exists($cvFile)) {
                unlink($cvFile);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucun fichier à supprimer.']);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'load') {
        if (file_exists($cvFile)) {
            echo json_encode(['cvFile' => $cvFile]);
        } else {
            echo json_encode(['cvFile' => null]);
        }
    }
    $cv_url = 'pfa/cv_doss/' . $cv_name;
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO chercheuremploi	 (Nom, Prenom, Adresse, Numero_Tel, Email, Password,CV_url,secteur_activité) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssss", $name, $prenom, $adresse, $numero_tel, $email, $hashed_password, $cv_url,$sec);
  
    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful, redirect to login page

        header("Location: coonexionchercheur.php");
        exit;
    } else {
        // Error occurred, redirect back to registration page with error message
        header("Location: register.html?error=RegistrationError");
        exit;
    }

    // Close statement
    $stmt->close();

}
// Close connection
mysqli_close($conn);
?>

