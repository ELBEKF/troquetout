<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/model/message.php'; // on crée ce fichier ensuite

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour envoyer un message.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $toUserId = intval($_POST['to_user_id'] ?? 0);
    $offerId = intval($_POST['offer_id'] ?? 0);
    $messageText = trim($_POST['message'] ?? '');

    if ($toUserId && $offerId && !empty($messageText)) {
        $messageModel = new Message();
        $success = $messageModel->sendMessage($pdo, $_SESSION['user_id'], $toUserId, $offerId, $messageText);

        if ($success) {
            header("Location: offerdetail.php?id=$offerId&sent=1");
            exit;
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
