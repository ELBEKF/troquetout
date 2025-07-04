<?php
class Proposition {
    public function save(PDO $pdo, $offreur_id, $demande_id, $offre_id, $message) {
        $sql = "INSERT INTO reponses_demande (offreur_id, demande_id, offre_id, message, date_reponse)
                VALUES (:offreur_id, :demande_id, :offre_id, :message, NOW())";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':offreur_id' => $offreur_id,
            ':demande_id' => $demande_id,
            ':offre_id' => $offre_id,
            ':message' => $message
        ]);
    }
}
