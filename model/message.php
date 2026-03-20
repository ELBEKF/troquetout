<?php
/**
 * Modèle Message — Messagerie interne TroqueTout
 * ✅ Ajout : countUnread() + markAllAsRead() pour le système de notifications
 */
require_once __DIR__ . '/Database.php';

class Message extends Database {

    /**
     * Envoie un nouveau message.
     * is_read = 0 par défaut (non lu) → déclenche la notification
     */
    public function sendMessage(int $fromUserId, int $toUserId, int $offerId, string $content): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, offer_id, message, is_read, date_sent)
            VALUES (?, ?, ?, ?, 0, NOW())
        ");
        return $stmt->execute([$fromUserId, $toUserId, $offerId, $content]);
    }

    /**
     * Récupère les messages reçus par un utilisateur.
     */
    public function getMessagesForUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                messages.*,
                offers.titre  AS offer_title,
                users.nom     AS sender_name
            FROM messages
            JOIN offers ON messages.offer_id  = offers.id
            JOIN users  ON messages.sender_id = users.id
            WHERE messages.receiver_id = ?
            ORDER BY messages.date_sent DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Récupère les messages envoyés par un utilisateur.
     */
    public function getSentMessagesByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                messages.*,
                offers.titre    AS offer_title,
                users.nom       AS receiver_name
            FROM messages
            JOIN offers ON messages.offer_id    = offers.id
            JOIN users  ON messages.receiver_id = users.id
            WHERE messages.sender_id = ?
            ORDER BY messages.date_sent DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * ✅ NOUVEAU — Compte les messages non lus d'un utilisateur.
     * Utilisé par le header pour afficher/masquer le badge de notification.
     */
    public function countUnread(int $userId): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM messages
            WHERE receiver_id = :user_id
            AND   is_read     = 0
        ");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * ✅ NOUVEAU — Marque tous les messages reçus comme lus.
     * Appelé quand l'utilisateur ouvre sa messagerie.
     */
    public function markAllAsRead(int $userId): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE messages
            SET    is_read = 1
            WHERE  receiver_id = :user_id
            AND    is_read     = 0
        ");
        $stmt->execute([':user_id' => $userId]);
    }
}