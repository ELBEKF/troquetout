<?php
class Proposition {
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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
   
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}


}
    public function save( $offreur_id, $demande_id, $offre_id, $message) {
        $sql = "INSERT INTO reponses_demande (offreur_id, demande_id, offre_id, message, date_reponse)
                VALUES (:offreur_id, :demande_id, :offre_id, :message, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':offreur_id' => $offreur_id,
            ':demande_id' => $demande_id,
            ':offre_id' => $offre_id,
            ':message' => $message
        ]);
    }
}
