<?php
require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/AdminController.php';

session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère et sécurise les données du formulaire
    $id = intval($_POST['id'] ?? 0);
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $code_postal = trim($_POST['code_postal'] ?? '');

    $success = $controller->updateUser($pdo, $id, $nom, $prenom, $email, $telephone, $ville, $code_postal);

    if ($success) {
        $_SESSION['success'] = "Utilisateur modifié avec succès.";
        header('Location: /admin.php');
        exit;
    } else {
        $_SESSION['error'] = "Erreur lors de la modification.";
        // Pour réafficher le formulaire avec les données postées en cas d'erreur
        $user = [
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'ville' => $ville,
            'code_postal' => $code_postal,
        ];
        render('modifUser', ['user' => $user, 'error' => $_SESSION['error']]);
        exit;
    }
} else {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        header('Location: /admin.php');
        exit;
    }

    $user = $controller->getUserById($pdo, $id);

    if (!$user) {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header('Location: /admin.php');
        exit;
    }

    render('modifUser', ['user' => $user, 'error' => '']);
}
