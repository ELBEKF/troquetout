<?php

require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/User.php';

class UsersController
{
    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $ville = $_POST['ville'] ?? '';
            $code_postal = $_POST['code_postal'] ?? '';

            // Validation simple
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $userCheck = new Users();

                // Vérifie si l’e-mail existe déjà
                if ($userCheck->emailExists($email)) {
                    $error = 'Cet email est déjà utilisé.';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Créer un nouvel utilisateur
                    $user = new Users(
                        $nom,
                        $prenom,
                        $email,
                        $hashedPassword,
                        'utilisateur',
                        $telephone,
                        $ville,
                        $code_postal,
                        date('Y-m-d H:i:s')
                    );

                    $id = $user->addUsers();

                    if ($id) {
                        header('Location: /connexion');
                        exit;
                    } else {
                        $error = 'Une erreur est survenue lors de l\'inscription.';
                    }
                }
            }
        }

        render('inscription', [
            'title' => 'Inscription',
            'error' => $error
        ]);
    }

    public function profil()
    {
        // session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /connexion");
            exit;
        }

        $userModel = new Users();
        $profil = $userModel->readProfil($_SESSION['user_id']);

        render('profil', [
            "title" => "Mon profil",
            "profil" => $profil
        ]);
    }

    public function updateProfil()
    {
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];

            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $ville = $_POST['ville'] ?? '';
            $code_postal = $_POST['code_postal'] ?? '';

            $userModel = new Users();
            $userModel->updateUser($id, $nom, $prenom, $email, $telephone, $ville, $code_postal);

            header('Location: /modifUser');
            exit;
        }

        echo "Erreur : formulaire invalide.";
    }

public function modifProfil()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /connexion");
        exit;
    }

    $userModel = new Users();
    $user = $userModel->readProfil($_SESSION['user_id']);

    render('modifProfil', [
        'title' => 'Modifier mon profil',
        'user' => $user,
        'error' => ''
    ]);
}


}

