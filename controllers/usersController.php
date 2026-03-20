<?php

require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/Users.php';

class UsersController
{
    /**
     * Inscription d'un nouvel utilisateur
     */
    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom         = trim($_POST['nom'] ?? '');
            $prenom      = trim($_POST['prenom'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $password    = $_POST['password'] ?? '';
            
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                $userModel = new Users();

                if ($userModel->emailExists($email)) {
                    $error = 'Cet email est déjà utilisé.';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // prépare les données pour le modèle
                    $userData = [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'password' => $hashedPassword,
                        'role' => 'utilisateur',
                        'telephone' => $_POST['telephone'] ?? '',
                        'ville' => $_POST['ville'] ?? '',
                        'code_postal' => $_POST['code_postal'] ?? ''
                    ];

                    if ($userModel->addUsers($userData)) {
                        $_SESSION['success'] = "Inscription réussie ! Vous pouvez vous connecter.";
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

    /**
     * Affiche le profil de l'utilisateur connecté
     */
    public function profil()
    {
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

    /**
     * Traite la mise à jour complète des informations du profil
     */
    public function updateProfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            $userModel = new Users();

            $userData = [
                'nom'         => trim($_POST['nom'] ?? ''),
                'prenom'      => trim($_POST['prenom'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'telephone'   => trim($_POST['telephone'] ?? ''),
                'ville'       => trim($_POST['ville'] ?? ''),
                'code_postal' => trim($_POST['code_postal'] ?? '')
            ];

            if ($userModel->updateProfil($id, $userData)) {
                $_SESSION['user_nom'] = $userData['nom'];
                $_SESSION['success'] = "Votre profil a été mis à jour avec succès.";
                header('Location: /profil');
                exit;
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la mise à jour.";
                header('Location: /profil/modifProfil');
                exit;
            }
        }
    }
    /**
     * Affiche le formulaire de modification
     */
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