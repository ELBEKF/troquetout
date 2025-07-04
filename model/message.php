<?php

class Message {
    public function sendMessage($pdo, $fromUserId, $toUserId, $offerId, $content) {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, offer_id, message, date_sent) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$fromUserId, $toUserId, $offerId, $content]);
    }

    public function getMessagesForUser($pdo, $userId) {
        $stmt = $pdo->prepare("
            SELECT messages.*, offers.titre AS offer_title, users.nom AS sender_name
            FROM messages
            JOIN offers ON messages.offer_id = offers.id
            JOIN users ON messages.sender_id = users.id
            WHERE messages.receiver_id = ?
            ORDER BY messages.date_sent DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
