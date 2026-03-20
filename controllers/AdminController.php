<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'Users.php';

class AdminController {

    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        $userModel = new Users(); 
        $offerModel = new Offers();

        $users = $userModel->getAllUsers();
        $offers = $offerModel->findAll();

        $stats = [
            'total_users' => count($users),
            'total_offers' => count($offers),
        ];

        render('dashboard', [
            'title' => 'Dashboard Admin',
            'users' => $users,
            'offers' => $offers,
            'stats' => $stats
        ]);
    }

    public function deleteUser($id) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        if ($_SESSION['user_id'] == $id) {
            $_SESSION['error'] = "Action impossible : vous ne pouvez pas supprimer votre propre compte.";
            header('Location: /admin');
            exit;
        }

        $userModel = new Users();
        $userModel->deleteUserById($id);

        $_SESSION['success'] = "Utilisateur supprimé.";
        header('Location: /admin');
        exit;
    }

    public function deleteOffer($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        $offerModel = new Offers();
        $offerModel->deleteOffer($id);
        
        $_SESSION['success'] = "Offre supprimée.";
        header('Location: /admin');
        exit;
    }

    public function modifUser(int $id) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        $userModel = new Users();
        $user = $userModel->readProfil($id);

        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            header('Location: /admin');
            exit;
        }

        render('modifUser', [
            'title' => "Modifier l'utilisateur",
            'user'  => $user
        ]);
    }

    public function updateUser(int $id) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        $userModel = new Users();
        $data = [
            'nom'         => trim($_POST['nom']         ?? ''),
            'prenom'      => trim($_POST['prenom']      ?? ''),
            'email'       => trim($_POST['email']       ?? ''),
            'telephone'   => trim($_POST['telephone']   ?? ''),
            'ville'       => trim($_POST['ville']       ?? ''),
            'code_postal' => trim($_POST['code_postal'] ?? ''),
        ];

        if ($userModel->updateUser(
            $id,
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['ville'],
            $data['code_postal']
        )) {
            $_SESSION['success'] = "Utilisateur mis à jour.";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour.";
        }

        header('Location: /admin');
        exit;
    }
}