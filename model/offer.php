<?php
require_once dirname(__DIR__) . '/config/database.php';

class Offers
{
    private $id;
    private $titre;
    private $description;
    private $sens;
    private $type;
    private $categorie;
    private $etat;
    private $prix;
    private $caution;
    private $localisation;
    private $photo;
    private $disponibilite;
    private $statut;
    private $date_creation;
    private $user_id;

    
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

    public function findAll()
    {
        $query = "SELECT * FROM offers";
        $pdostmt = $this->pdo->prepare($query);
        $pdostmt->execute();

        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOffers()
    {
        try {
            $query = "
                INSERT INTO offers (
                    titre, description, sens, type, categorie, etat, prix, caution, localisation, photo, disponibilite, statut, user_id, date_creation
                ) VALUES (
                    :titre, :description, :sens, :type, :categorie, :etat, :prix, :caution, :localisation, :photo, :disponibilite, :statut,:user_id, NOW()
                )
            ";

            $pdostmt = $this->pdo->prepare($query);

            return $pdostmt->execute([
                ":titre"         => $this->titre,
                ":description"   => $this->description,
                ":sens"          => $this->sens,
                ":type"          => $this->type,
                ":categorie"     => $this->categorie,
                ":etat"          => $this->etat,
                ":prix"          => $this->prix,
                ":caution"       => $this->caution,
                ":localisation"  => $this->localisation,
                ":photo"         => $this->photo,
                ":disponibilite" => $this->disponibilite,
                ":statut"        => $this->statut,
                ":user_id"       => $this->user_id
            ]);

        } catch (PDOException $e) {
            echo "<strong>Erreur SQL :</strong> " . $e->getMessage() . "<br>";
            echo "<strong>Données de l'objet :</strong><pre>";
            var_dump($this);
            echo "</pre>";
            return false;
        }
    }

    public function findOfferById( $id)
    {
        $sql = "SELECT * FROM offers WHERE id = :id";
        $pdostmt = $this->pdo->prepare($sql);
        $pdostmt->execute(['id' => $id]);
        return $pdostmt->fetch(PDO::FETCH_ASSOC);
    }

public function deleteOffer( $id)
{
    $sql = "DELETE FROM offers WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

public function updateOfferInDb( $id)
{
    $sql = "
        UPDATE offers SET
            titre = :titre,
            description = :description,
            sens = :sens,
            type = :type,
            categorie = :categorie,
            etat = :etat,
            prix = :prix,
            caution = :caution,
            localisation = :localisation,
            photo = :photo,
            disponibilite = :disponibilite,
            statut = :statut
        WHERE id = :id
    ";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':titre'         => $this->titre,
        ':description'   => $this->description,
        ':sens'          => $this->sens,
        ':type'          => $this->type,
        ':categorie'     => $this->categorie,
        ':etat'          => $this->etat,
        ':prix'          => $this->prix,
        ':caution'       => $this->caution,
        ':localisation'  => $this->localisation,
        ':photo'         => $this->photo,
        ':disponibilite' => $this->disponibilite,
        ':statut'        => $this->statut,
        ':id'            => $id
    ]);
}



public function getByUserId( $userId) {
    $stmt = $this->pdo->prepare("SELECT * FROM offers WHERE user_id = :user_id ORDER BY date_creation DESC");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




// offer_functions.php ou offerModel.php (hors de la classe)
public function addFavori( int $userId, int $offerId): bool {
    $stmt = $this->pdo->prepare("INSERT IGNORE INTO favoris (user_id, offer_id) VALUES (:user_id, :offer_id)");
    return $stmt->execute([
        'user_id' => $userId,
        'offer_id' => $offerId
    ]);
}

public function getFavorisByUser( int $userId): array {
    $stmt = $this->pdo->prepare("
        SELECT o.* FROM offers o
        JOIN favoris f ON o.id = f.offer_id
        WHERE f.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function toggleFavoris( $userId, $offerId) {
    // Vérifier si l'offre est déjà en favoris
    $stmt = $this->pdo->prepare("SELECT * FROM favoris WHERE user_id = :user_id AND offer_id = :offer_id");
    $stmt->execute(['user_id' => $userId, 'offer_id' => $offerId]);
    $exists = $stmt->fetch();

    if ($exists) {
        // Supprimer des favoris
        $stmt = $this->pdo->prepare("DELETE FROM favoris WHERE user_id = :user_id AND offer_id = :offer_id");
        $stmt->execute(['user_id' => $userId, 'offer_id' => $offerId]);
        return false; // retiré des favoris
    } else {
        // Ajouter aux favoris
        $stmt = $this->pdo->prepare("INSERT INTO favoris (user_id, offer_id, date_ajout) VALUES (:user_id, :offer_id, NOW())");
        $stmt->execute(['user_id' => $userId, 'offer_id' => $offerId]);
        return true; // ajouté aux favoris
    }
}

// pratique pour l’affichage (coeur rempli ou vide)
    public function isFavorite($userId, $offerId)
    {
        $sql = "SELECT COUNT(*) FROM favorites WHERE user_id = :user_id AND offer_id = :offer_id";
        $pdostmt = $this->pdo->prepare($sql);
        $pdostmt->execute([
            ':user_id' => $userId,
            ':offer_id' => $offerId
        ]);
        return $pdostmt->fetchColumn() > 0;
    }

public function getAllOffersWithFavoris( ?int $userId = null): array
{
    if ($userId === null) {
        $sql = "SELECT o.*, 0 AS is_favori FROM offers o ORDER BY o.date_creation DESC";
        $stmt = $this->pdo->query($sql);
    } else {
        $sql = "
            SELECT o.*,
            CASE 
                WHEN f.id IS NOT NULL THEN 1
                ELSE 0
            END AS is_favori
            FROM offers o
            LEFT JOIN favoris f ON o.id = f.offer_id AND f.user_id = :user_id
            ORDER BY o.date_creation DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function searchOffersByTitre( $search) {
$sql = "SELECT * FROM offers WHERE titre LIKE :search";
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['search' => '%' . $search . '%']);
return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function findWithFilters( $search = '', $type = '', $etat ='', $localisation ='', $sort ='')
{
    $query = "SELECT * FROM offers WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $query .= " AND titre LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    if (!empty($type)) {
        $query .= " AND type = :type";
        $params[':type'] = $type;
    }

    if (!empty($etat)) {
        $query .= " AND etat = :etat";
        $params[':etat'] = $etat;
    }

    if (!empty($localisation)) {
        $query .= " AND localisation LIKE :localisation";
        $params[':localisation'] = '%' . $localisation . '%';
    }
    $sort = strtolower($sort) === 'asc' ? 'ASC' : 'DESC';
    $query .= " ORDER BY date_creation $sort";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function findWithFiltersAndFavoris($search = '', $type = '', $etat = '', $localisation = '', $sort = '', $userId = null)
{
    $query = "SELECT o.*, ";
    
    if ($userId !== null) {
        $query .= "CASE WHEN f.id IS NOT NULL THEN 1 ELSE 0 END AS is_favori ";
    } else {
        $query .= "0 AS is_favori ";
    }
    
    $query .= "FROM offers o ";
    
    if ($userId !== null) {
        $query .= "LEFT JOIN favoris f ON o.id = f.offer_id AND f.user_id = :user_id ";
    }
    
    $query .= "WHERE 1=1";
    $params = [];

    if ($userId !== null) {
        $params[':user_id'] = $userId;
    }

    if (!empty($search)) {
        $query .= " AND o.titre LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    if (!empty($type)) {
        $query .= " AND o.type = :type";
        $params[':type'] = $type;
    }

    if (!empty($etat)) {
        $query .= " AND o.etat = :etat";
        $params[':etat'] = $etat;
    }

    if (!empty($localisation)) {
        $query .= " AND o.localisation LIKE :localisation";
        $params[':localisation'] = '%' . $localisation . '%';
    }
    
    $sort = strtolower($sort) === 'asc' ? 'ASC' : 'DESC';
    $query .= " ORDER BY o.date_creation $sort";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Getters and setters...
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getTitre() { return $this->titre; }
    public function setTitre($titre) { $this->titre = $titre; return $this; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; return $this; }
    public function getSens() { return $this->sens; }
    public function setSens($sens) { $this->sens = $sens; return $this; }
    public function getType() { return $this->type; }
    public function setType($type) { $this->type = $type; return $this; }
    public function getCategorie() { return $this->categorie; }
    public function setCategorie($categorie) { $this->categorie = $categorie; return $this; }
    public function getEtat() { return $this->etat; }
    public function setEtat($etat) { $this->etat = $etat; return $this; }
    public function getPrix() { return $this->prix; }
    public function setPrix($prix) { $this->prix = $prix; return $this; }
    public function getCaution() { return $this->caution; }
    public function setCaution($caution) { $this->caution = $caution; return $this; }
    public function getLocalisation() { return $this->localisation; }
    public function setLocalisation($localisation) { $this->localisation = $localisation; return $this; }
    public function getPhoto() { return $this->photo; }
    public function setPhoto($photo) { $this->photo = $photo; return $this; }
    public function getDisponibilite() { return $this->disponibilite; }
    public function setDisponibilite($disponibilite) { $this->disponibilite = $disponibilite; return $this; }
    public function getStatut() { return $this->statut; }
    public function setStatut($statut) { $this->statut = $statut; return $this; }
    public function getDate_creation() { return $this->date_creation; }
    public function setDate_creation($date_creation) { $this->date_creation = $date_creation; return $this; }
    public function getUserId() {
    return $this->user_id;
}

public function setUserId($user_id) {
    $this->user_id = $user_id;
    return $this;
}

}
