<?php
// On démarre la session pour accéder aux données de l'utilisateur connecté
session_start();

// On inclut les fichiers nécessaires : 
require_once 'config/database.php';          // Fichier de configuration pour la base de données (connexion PDO)
require_once 'config/render.php';            // Fichier qui contient une fonction pour afficher les pages (templates)
require_once 'controllers/AdminController.php'; // Fichier qui contient la classe AdminController

// ==========================
// Vérification de sécurité :
// ==========================
// On vérifie si l'utilisateur est connecté (user_id présent en session)
// et si son rôle est bien "admin"
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Si ce n'est pas un admin, on le redirige vers la page d'accueil
    header('Location: /'); // Redirection
    exit;                 // On arrête le script ici
}

// ==========================
// Appel du contrôleur Admin
// ==========================
// On crée un objet AdminController
$controller = new AdminController();

// On appelle la méthode dashboard() pour afficher la page admin
// et on lui passe $pdo (connexion à la base)
$controller->dashboard($pdo);
