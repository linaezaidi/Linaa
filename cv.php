<?php
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
            header('Location: cv.php');
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
} else {
    // Afficher la page HTML
    include('cv.html');
}
?>
