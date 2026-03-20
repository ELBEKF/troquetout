<?php

require_once dirname(__DIR__) . '/model/message.php';
require_once dirname(__DIR__) . '/config/render.php';

class MessagesController {

    public function receivedMessages() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit;
        }

        $userId       = $_SESSION['user_id'];
        $messageModel = new Message();

        $messageModel->markAllAsRead($userId);

        $_SESSION['unread_count'] = 0;

        $receivedMessages = $messageModel->getMessagesForUser($userId);
        $sentMessages     = $messageModel->getSentMessagesByUser($userId);

        render('messages_reçus', [
            'title'    => 'Ma Messagerie',
            'messages' => $receivedMessages,
            'sent'     => $sentMessages,
        ]);
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit;
        }

        $fromUserId = $_SESSION['user_id'];
        $toUserId   = intval($_POST['to_user_id'] ?? 0);
        $offerId    = intval($_POST['offer_id']   ?? 0);
        $content    = trim($_POST['message']      ?? '');

        if (!$toUserId || !$offerId || empty($content)) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
            header('Location: /messages_recus');
            exit;
        }

        $messageModel = new Message();
        $success = $messageModel->sendMessage($fromUserId, $toUserId, $offerId, $content);

        if ($success) {
            $_SESSION['success'] = "Votre message a été envoyé avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi du message.";
        }

        header('Location: /messages_recus');
        exit;
    }

    public static function refreshUnreadCount(): void
    {
        if (!isset($_SESSION['user_id'])) return;
        $messageModel = new Message();
        $_SESSION['unread_count'] = $messageModel->countUnread((int)$_SESSION['user_id']);
    }
}