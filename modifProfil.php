<?php
session_start();
require_once 'config/database.php';
require_once 'config/render.php';
require_once 'model/user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

$userModel = new Users();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $code_postal = trim($_POST['code_postal'] ?? '');

    $success = $userModel->updateUser($pdo, $userId, $nom, $prenom, $email, $telephone, $ville, $code_postal);

    if ($success) {
        $_SESSION['success'] = "Profil mis à jour avec succès.";
        header('Location: /profil.php');
        exit;
    } else {
        $error = "Erreur lors de la mise à jour.";
    }
} else {
    $user = $userModel->readProfil($pdo, $userId);
}

render('modifProfil', [
    'user' => $user ?? $_POST,
    'error' => $error ?? '',
    'title' => 'Modifier mon profil'
]);
