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

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function findAll($pdo)
    {
        $query = "SELECT * FROM offers";
        $pdostmt = $pdo->prepare($query);
        $pdostmt->execute();

        return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOffers($pdo)
    {
        try {
            $query = "
                INSERT INTO offers (
                    titre, description, sens, type, categorie, etat, prix, caution, localisation, photo, disponibilite, statut, user_id, date_creation
                ) VALUES (
                    :titre, :description, :sens, :type, :categorie, :etat, :prix, :caution, :localisation, :photo, :disponibilite, :statut,:user_id, NOW()
                )
            ";

            $pdostmt = $pdo->prepare($query);

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

    public function findOfferById($pdo, $id)
    {
        $sql = "SELECT * FROM offers WHERE id = :id";
        $pdostmt = $pdo->prepare($sql);
        $pdostmt->execute(['id' => $id]);
        return $pdostmt->fetch(PDO::FETCH_ASSOC);
    }

public function deleteOffer($pdo, $id)
{
    $sql = "DELETE FROM offers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

public function updateOfferInDb($pdo, $id)
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

    $stmt = $pdo->prepare($sql);
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

public function searchOffersByTitre($pdo, $search) {
$sql = "SELECT * FROM offers WHERE titre LIKE :search";
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => '%' . $search . '%']);
return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function findWithFilters($pdo, $search = '', $type = '', $etat ='', $localisation ='', $sort ='')
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

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getByUserId($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM offers WHERE user_id = :user_id ORDER BY date_creation DESC");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




// offer_functions.php ou offerModel.php (hors de la classe)
public function addFavori(PDO $pdo, int $userId, int $offerId): bool {
    $stmt = $pdo->prepare("INSERT IGNORE INTO favoris (user_id, offer_id) VALUES (:user_id, :offer_id)");
    return $stmt->execute([
        'user_id' => $userId,
        'offer_id' => $offerId
    ]);
}

public function getFavorisByUser(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare("
        SELECT o.* FROM offers o
        JOIN favoris f ON o.id = f.offer_id
        WHERE f.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $userId]);
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
