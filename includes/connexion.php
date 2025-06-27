<?php
session_start();
require_once dirname(__DIR__) . '/config/database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["inputEmail"];
    $password =$_POST["inputMdp"];
  
    $query = "SELECT * FROM users WHERE email = :email";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute(['email' => $email]);
    $user = $pdostmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $password === $user['password']) {
        // ici on stocke les infos importantes dans la session
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        header('Location: /offers.php');
        exit;
    } else if (!empty($email) && !empty($_POST["inputMdp"])) {
        $_SESSION['error'] = "L'identifiant et/ou mot de passe est incorrect !";
    } else {
        $_SESSION['error'] = "Les champs sont vides, veuillez les remplir !";
    }

    header('Location: /index.php');
    exit;
}