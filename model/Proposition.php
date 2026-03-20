<?php
/**
 * Modèle Proposition — Gère les réponses aux demandes d'objets
 */
require_once __DIR__ . '/Database.php';

class Proposition extends Database {

    /**
     * Enregistre une proposition de troc dans la base de données
     */
    public function save($offreur_id, $demande_id, $offre_id, $message) {
        $sql = "INSERT INTO reponses_demande (offreur_id, demande_id, offre_id, message, date_reponse)
                VALUES (:offreur_id, :demande_id, :offre_id, :message, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':offreur_id' => $offreur_id,
            ':demande_id' => $demande_id,
            ':offre_id'   => $offre_id,
            ':message'    => $message
        ]);
    }
}