<?php
/**
 * Modèle Offers - Version Complète Restaurée
 * Hérite de la classe Database pour la connexion PDO
 */

require_once __DIR__ . '/Database.php';

class Offers extends Database
{
    // --- PROPRIÉTÉS ---
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

    // --- LOGIQUE MÉTIER / SQL ---

    public function findAll() {
        return $this->pdo->query("SELECT * FROM offers ORDER BY date_creation DESC")->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findOfferById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM offers WHERE id = :id");
    $stmt->execute(['id' => $id]);
    // ✅ Utilisation de FETCH_ASSOC pour garantir l'accès par $modif['titre']
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}

    public function findWithFiltersAndFavoris($search = '', $type = '', $etat = '', $localisation = '', $sort = '', $userId = null) {
        $query = "SELECT o.*, ";
        $query .= ($userId !== null) ? "CASE WHEN f.id IS NOT NULL THEN 1 ELSE 0 END AS is_favori " : "0 AS is_favori ";
        $query .= "FROM offers o ";
        if ($userId !== null) $query .= "LEFT JOIN favoris f ON o.id = f.offer_id AND f.user_id = :user_id ";
        
        $query .= "WHERE 1=1";
        $params = ($userId !== null) ? [':user_id' => $userId] : [];

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
        
        $sortOrder = (strtolower($sort) === 'asc') ? 'ASC' : 'DESC';
        $query .= " ORDER BY o.date_creation $sortOrder";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // AVANT : public function addOffers() { ... }
// APRÈS :
public function addOffers($data) 
{
    $sql = "INSERT INTO offers (
                titre, 
                description, 
                sens, 
                type, 
                categorie, 
                etat, 
                prix, 
                caution, 
                localisation, 
                photo, 
                disponibilite, 
                statut, 
                user_id
            ) VALUES (
                :titre, 
                :description, 
                :sens, 
                :type, 
                :categorie, 
                :etat, 
                :prix, 
                :caution, 
                :localisation, 
                :photo, 
                :disponibilite, 
                :statut, 
                :user_id
            )";
    
    $stmt = $this->pdo->prepare($sql);
    
    // On exécute la requête avec le tableau $data reçu en paramètre
    return $stmt->execute($data);
}

    // updateOfferInDb() supprimée : utilisait $this->titre etc. jamais hydratés
    // Utilisez updateOffer($id, $data, $isAdmin) à la place.


  public function deleteOffer($id) {
    $stmt = $this->pdo->prepare("DELETE FROM offers WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

    public function toggleFavoris($userId, $offerId) {
        $stmt = $this->pdo->prepare("SELECT * FROM favoris WHERE user_id = :user_id AND offer_id = :offer_id");
        $stmt->execute(['user_id' => $userId, 'offer_id' => $offerId]);
        if ($stmt->fetch()) {
            $this->pdo->prepare("DELETE FROM favoris WHERE user_id = ? AND offer_id = ?")->execute([$userId, $offerId]);
            return false;
        } else {
            $this->pdo->prepare("INSERT INTO favoris (user_id, offer_id, date_ajout) VALUES (?, ?, NOW())")->execute([$userId, $offerId]);
            return true;
        }
    }

    public function getFavorisByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT o.* FROM offers o JOIN favoris f ON o.id = f.offer_id WHERE f.user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

   public function getByUserId($userId): array 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM offers WHERE user_id = :user_id ORDER BY date_creation DESC");
        $stmt->execute(['user_id' => $userId]);
        
        // On récupère les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On s'assure de toujours retourner un tableau (même vide) pour éviter le type "null" ou "void"
        return $results ?: []; 
    }
    // ✅ APRÈS — Si admin, pas de restriction sur user_id
/**
     * Met à jour une offre.
     *
     * ✅ MVC : $_SESSION ne doit JAMAIS être lu dans le modèle.
     *    La logique admin/propriétaire est décidée dans le CONTRÔLEUR
     *    et transmise via le paramètre $isAdmin.
     *
     * @param int   $id      Id de l'offre
     * @param array $data    Données du formulaire
     * @param bool  $isAdmin True si appelé depuis un contexte admin
     */
    public function updateOffer(int $id, array $data, bool $isAdmin = false): bool
    {
        $sql = "UPDATE offers SET
                    titre        = :titre,
                    description  = :description,
                    type         = :type,
                    sens         = :sens,
                    categorie    = :categorie,
                    etat         = :etat,
                    prix         = :prix,
                    caution      = :caution,
                    localisation = :localisation,
                    disponibilite= :disponibilite,
                    statut       = :statut,
                    photo        = :photo
                WHERE id = :id";

        // Pas admin → on restreint au propriétaire de l'offre (sécurité)
        if (!$isAdmin) {
            $sql .= " AND user_id = :user_id";
        }

        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;

        // Admin → user_id non nécessaire dans les params PDO
        if ($isAdmin) {
            unset($data['user_id']);
        }

        return $stmt->execute($data);
    }

    // --- GETTERS & SETTERS (Restaurés) ---
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
    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; return $this; }
}