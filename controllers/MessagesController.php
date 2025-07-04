<?php 

// On importe les fichiers nécessaires
require_once dirname(__DIR__) . '/model/message.php'; // Modèle Message (pour interagir avec la BDD)
require_once dirname(__DIR__) . '/config/render.php'; // Fonction render() pour afficher les pages

// =======================
// Contrôleur Messages
// =======================
class MessagesController {

    // -------------------------------
    // Méthode : Afficher les messages reçus
    // -------------------------------
    public function receivedMessages($pdo) {
        // Vérifie si l'utilisateur est connecté (via session)
        if (!isset($_SESSION['user_id'])) {
            // Si pas connecté, on redirige vers la page de connexion
            header('Location: /login.php');
            exit;
        }

        // Récupère l'ID de l'utilisateur connecté depuis la session
        $userId = $_SESSION['user_id'];

        // On crée une instance du modèle Message
        $messageModel = new Message();

        // Récupère les messages destinés à cet utilisateur
        $messages = $messageModel->getMessagesForUser($pdo, $userId);

        // Affiche la page "messages_reçus" avec les messages
        render('messages_reçus', [
            'title' => 'Mes messages reçus', // Titre de la page
            'messages' => $messages           // Données à envoyer à la vue
        ]);
    }

    // -------------------------------
    // Méthode : Envoyer un message
    // -------------------------------
    public function send($pdo) {
        session_start(); // Démarre la session (pour vérifier l'utilisateur)

        // Vérifie que la requête est bien en POST (formulaire envoyé)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifie que l'utilisateur est connecté
            if (!isset($_SESSION['user_id'])) {
                // Si pas connecté, redirige vers la page de login
                header("Location: /login.php");
                exit;
            }

            // Récupère l'ID de l'expéditeur (utilisateur connecté)
            $fromUserId = $_SESSION['user_id'];

            // Récupère les champs du formulaire
            $toUserId = intval($_POST['to_user_id'] ?? 0); // Destinataire
            $offerId = intval($_POST['offer_id'] ?? 0);    // L'offre concernée
            $content = trim($_POST['message'] ?? '');      // Contenu du message

            // Vérifie que tous les champs sont remplis
            if ($toUserId && $offerId && !empty($content)) {
                // Crée une instance du modèle Message
                $messageModel = new Message();

                // Appelle la méthode pour enregistrer le message dans la BDD
                $messageModel->sendMessage($pdo, $fromUserId, $toUserId, $offerId, $content);

                // Redirige vers la page des messages reçus avec un succès
                header("Location: /messages_reçus.php?success=1");
                exit;
            } else {
                // Si un champ est vide, affiche une erreur
                echo "Tous les champs sont obligatoires.";
            }
        }
    }
}
