<?php

require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../config/render.php'; 
require_once __DIR__ . '/../model/Users.php';

class ConnexionController {

    public function showForm() {
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        render('connexion', [
            'title' => 'Connexion',
            'error' => $error
        ]);
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['inputEmail'] ?? '';
            $password = $_POST['inputMdp'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Les champs sont vides, veuillez les remplir !";
                header('Location: /connexion');
                exit;
            }

            $userModel = new Users();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Stockage des informations en session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_role'] = $user['role'];

                header('Location: /');
                exit;
            } else {
                $_SESSION['error'] = "L'identifiant et/ou mot de passe est incorrect !";
                header('Location: /connexion');
                exit;
            }
        }
    }
}