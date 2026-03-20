<?php
/**
 * Modèle Request — Gestion des demandes d'objets (besoins des membres)
 * Version intégrale et optimisée pour l'architecture MVC
 */

require_once __DIR__ . '/Database.php';

class Request extends Database {

    /**
     * Crée une nouvelle demande dans la base de données
     */
    public function create($data) {
        // Utilisation de $this->pdo hérité de la classe Database
        $stmt = $this->pdo->prepare("INSERT INTO requests (user_id, titre, description, type_demande, date_besoin)
                                     VALUES (:user_id, :titre, :description, :type_demande, :date_besoin)");
        return $stmt->execute($data);
    }

    /**
     * Récupère toutes les demandes avec le nom et prénom de l'auteur (Jointure)
     */
    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT r.*, u.nom, u.prenom FROM requests r
                                   JOIN users u ON r.user_id = u.id
                                   ORDER BY r.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour une demande existante
     * Sécurité : Vérifie que l'ID de la demande appartient bien à l'utilisateur
     */
    public function update($id, $data) {
        $sql = "UPDATE requests SET 
                    titre = :titre, 
                    description = :description, 
                    type_demande = :type_demande, 
                    date_besoin = :date_besoin 
                WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    /**
     * Supprime une demande spécifique
     */
    public function delete($id, $user_id) {
        $sql = "DELETE FROM requests WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
    }

    /**
     * Récupère une demande par son ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les demandes postées par un utilisateur précis
     */
    public function getByUserId($userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}