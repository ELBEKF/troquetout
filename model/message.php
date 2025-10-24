<?php

class Message {
    private $pdo;
    
    public function __construct(){
        // Connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=troquetout;charset=utf8";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                // Activation des erreurs PDO (bonnes pratiques)
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
        }
    }
    
    public function sendMessage($fromUserId, $toUserId, $offerId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (sender_id, receiver_id, offer_id, message, date_sent) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$fromUserId, $toUserId, $offerId, $content]);
    }

    public function getMessagesForUser($userId) {
        $stmt = $this->pdo->prepare("
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

    // Nouvelle méthode pour récupérer les messages envoyés par un utilisateur
    public function getSentMessagesByUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT messages.*, 
                   offers.titre AS offer_title, 
                   users.nom AS receiver_name
            FROM messages
            JOIN offers ON messages.offer_id = offers.id
            JOIN users ON messages.receiver_id = users.id
            WHERE messages.sender_id = ?
            ORDER BY messages.date_sent DESC
            
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}