<?php
// On importe les fichiers nécessaires (classes User et Offer, etc.)
require_once dirname(__DIR__) . '/model/user.php';  // fichier du modèle utilisateur
require_once dirname(__DIR__) . '/model/offer.php'; // fichier du modèle offre
require_once dirname(__DIR__) . '/model/User.php';  // fichier du modèle utilisateur (majuscule)

class AdminController { // Définition d'une classe pour gérer les fonctions d'administration

    // Cette fonction affiche le tableau de bord (dashboard) de l'admin
    public function dashboard($pdo) {
        // Vérifier si l'utilisateur est connecté et est bien un admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            // Si pas admin, on le renvoie vers la page d'accueil
            header('Location: /');
            exit;
        }

        // On crée un objet Users (pour récupérer les utilisateurs)
        $userModel = new Users(); 

        // On crée un objet Offers (pour récupérer les offres)
        $offerModel = new Offers();

        // Récupérer tous les utilisateurs dans la base
        $users = $userModel->getAllUsers($pdo);

        // Récupérer toutes les offres dans la base
        $offers = $offerModel->findAll($pdo);

        // On calcule des statistiques simples
        $stats = [
            'total_users' => count($users),       // nombre total d'utilisateurs
            'total_offers' => count($offers),     // nombre total d'offres
        ];

        // On affiche la page du dashboard avec les données
        render('dashboard', [
            'title' => 'Dashboard Admin', // titre de la page
            'users' => $users,            // liste des utilisateurs
            'offers' => $offers,          // liste des offres
            'stats' => $stats             // statistiques
        ]);
    }

    // Cette fonction supprime un utilisateur
    public function deleteUser($pdo, $id) {
        session_start(); // Démarre une session pour vérifier qui est connecté

        // Vérifie si l'utilisateur connecté est un admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // Si ce n'est pas un admin, on le renvoie à la page d'accueil
            header('Location: /index.php');
            exit;
        }

        // Empêche l'admin de supprimer son propre compte
        if ($_SESSION['user_id'] == $id) {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer votre propre compte administrateur.";
            header('Location: /admin.php');
            exit;
        }

        try {
            // Crée un objet Users pour supprimer l'utilisateur
            $userModel = new Users();
            $userModel->deleteUserById($pdo, $id); // supprime l'utilisateur par son id

            $_SESSION['success'] = "Utilisateur supprimé avec succès."; // message de succès
        } catch (Exception $e) {
            // En cas d'erreur, on enregistre le message d'erreur
            $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
        }

        // Après suppression, on retourne au dashboard admin
        header('Location: /admin.php');
        exit;
    }

    // Cette fonction supprime une offre
    public function deleteOffer($pdo, $id) {
        // Vérifie si l'utilisateur est un admin
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: /'); // Si pas admin, redirection vers l'accueil
            exit;
        }

        // Crée un objet Offers pour supprimer l'offre
        $offerModel = new Offers();
        $offerModel->deleteOffer($pdo, $id); // supprime l'offre par son id
        header('Location: /admin.php'); // Retourne au dashboard admin
        exit;
    }

    // Cette fonction récupère un utilisateur selon son ID
    public function getUserById($pdo, $id) {
        $userModel = new Users(); // Crée un objet Users
        return $userModel->getUserById($pdo, $id); // Retourne les infos de l'utilisateur
    }

    // Cette fonction permet à l'admin de mettre à jour un utilisateur
    public function updateUser($pdo, $id, $nom, $prenom, $email, $telephone = null, $ville = null, $code_postal = null) {
        session_start(); // Démarre une session pour vérifier qui est connecté

        // Vérifie que l'utilisateur connecté est bien un admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            return false; // Si pas admin, on arrête la fonction
        }

        // Crée un objet Users pour mettre à jour l'utilisateur
        $userModel = new Users();
        return $userModel->updateUser($pdo, $id, $nom, $prenom, $email, $telephone, $ville, $code_postal);
    }

}
