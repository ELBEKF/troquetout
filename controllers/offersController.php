<?php 

require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/Offers.php'; // On utilise le nom de classe correct

class OffersController {

    public function index() {
        $search       = $_GET['search'] ?? '';
        $type         = $_GET['type'] ?? '';
        $etat         = $_GET['etat'] ?? '';
        $localisation = $_GET['localisation'] ?? '';
        $sort         = $_GET['sort'] ?? 'desc';

        $userId = $_SESSION['user_id'] ?? null;
        
        $offerModel = new Offers();

        $offers = $offerModel->findWithFiltersAndFavoris($search, $type, $etat, $localisation, $sort, $userId);

        render('homepage', [
            "title"        => "Accueil - TroqueTout",
            "offers"       => $offers,
            "search"       => $search,
            "type"         => $type,
            "etat"         => $etat,
            "localisation" => $localisation,
            "sort"         => $sort,
        ]);
    }

    /**
     * Détail d'une offre spécifique
     */
    public function offerDetail($id) {
        $offerModel = new Offers();
        $detail = $offerModel->findOfferById(intval($id));

        if (!$detail) {
            $_SESSION['error'] = "Cette annonce n'existe pas ou a été supprimée.";
            header('Location: /');
            exit;
        }

        render('offerdetail', [
            "title"  => $detail['titre'],
            "detail" => $detail
        ]);
    }

   // Dans OffersController.php
public function handleAddOffer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $offerModel = new Offers();
        $photo_path = '/assets/images/default-offer.png';

        // Gestion de l'upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/offers/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $newName   = uniqid('offer_', true) . '.' . $extension;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newName)) {
                $photo_path = '/uploads/offers/' . $newName;
            }
        }

        // Préparation des données
        $data = [
            'titre'         => $_POST['titre'] ?? '',
            'description'   => $_POST['description'] ?? '',
            'sens'          => $_POST['sens'] ?? 'offre',
            'type'          => $_POST['type'] ?? 'don',
            'categorie'     => $_POST['categorie'] ?? 'Divers',
            'etat'          => $_POST['etat'] ?? 'bon',
            'prix'          => $_POST['prix'] ?? 0,
            'caution'       => $_POST['caution'] ?? 0,
            'localisation'  => $_POST['localisation'] ?? '',
            'disponibilite' => $_POST['disponibilite'] ?? date('Y-m-d'),
            'statut'        => intval($_POST['statut'] ?? 1),
            'photo'         => $photo_path,
            'user_id'       => $_SESSION['user_id']
        ];

        if ($offerModel->addOffers($data)) {
            $_SESSION['success'] = "Annonce créée avec succès !";
            header('Location: /mesoffres');
            exit;
        }

        $_SESSION['error'] = "Erreur lors de la création de l'annonce.";
    }

    render('addOffers', ['title' => 'Ajouter une offre']);
}
    public function toggleFavoris() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $offerId = $_POST['offer_id'] ?? null;

        if (!$offerId) {
            header('Location: /');
            exit;
        }

        $offerModel = new Offers();
        $isNowInFavoris = $offerModel->toggleFavoris($userId, $offerId);

        // Utilisation des messages flash centralisés dans base.html.php
        $_SESSION['success'] = $isNowInFavoris ? "Ajouté aux favoris." : "Retiré des favoris.";
        
        // Redirection vers la page d'où l'on vient
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $redirect);
        exit;
    }

    /**
     * Liste des favoris de l'utilisateur
     */
    public function favoris() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /connexion");
            exit;
        }

        $offerModel = new Offers();
        $favoris = $offerModel->getFavorisByUser($_SESSION['user_id']);

        render('mesfavoris', [
            'title'  => 'Mes favoris',
            'offers' => $favoris
        ]);
    }

 // OffersController.php
public function delete($id) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /connexion');
        exit;
    }

    $offerModel = new Offers();
    $offer = $offerModel->findOfferById($id);

    // Sécurité : Vérifier le propriétaire
    if (!$offer || ($_SESSION['user_id'] != $offer['user_id'] && $_SESSION['user_role'] !== 'admin')) {
        $_SESSION['error'] = "Action non autorisée.";
        header('Location: /mesoffres');
        exit;
    }

    // Suppression en base de données
    if ($offerModel->deleteOffer($id)) {
        $_SESSION['success'] = "L'annonce a été supprimée.";
    }
    
    // Redirection pour rafraîchir la page
    header("Location: /mesoffres");
    exit;
}
public function addFavori() 
{
    // 1. Vérification de la session
    if (!isset($_SESSION['user_id'])) {
        header("Location: /connexion");
        exit;
    }

    // 2. Traitement du formulaire POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offer_id'])) {
        $userId = $_SESSION['user_id'];
        $offerId = intval($_POST['offer_id']);

        $offerModel = new Offers();
        
        // 3. Appel au modèle (méthode toggleFavoris créer)
        $isNowInFavoris = $offerModel->toggleFavoris($userId, $offerId);

        // 4. Message flash pour l'utilisateur (optionnel)
        $_SESSION['success'] = $isNowInFavoris ? "Annonce ajoutée aux favoris." : "Annonce retirée des favoris.";

        // 5. Redirection vers la page d'origine
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: " . $redirect);
        exit;
    }
}

public function modifoffer($id) 
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /connexion');
        exit;
    }

    $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'] ?? '/mesoffres';

    $offerModel = new Offers();
    $offerData = $offerModel->findOfferById(intval($id));

    if (!$offerData || ($offerData['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin')) {
        $_SESSION['error'] = "Vous n'avez pas l'autorisation de modifier cette offre.";
        header('Location: /mesoffres');
        exit;
    }

    render('modifoffer', [
        'title' => 'Modifier mon annonce',
        'modif' => $offerData 
    ]);
}

public function updateoffer() 
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $offerModel = new Offers();
        $oldOffer = $offerModel->findOfferById($id);

        if (!$oldOffer) {
            header('Location: /mesoffres');
            exit;
        }

        // Gestion de la photo (via upload )
        $photo_path = $oldOffer['photo'];
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            // ... (votre logique move_uploaded_file ici) ...
        }

        $data = [
            'titre'         => $_POST['titre'],
            'description'   => $_POST['description'],
            'type'          => $_POST['type'],
            'sens'          => $_POST['sens'],
            'categorie'     => $oldOffer['categorie'], 
            'etat'          => $_POST['etat'],
            'prix'          => $_POST['prix'],
            'caution'       => $_POST['caution'],
            'localisation'  => $_POST['localisation'],
            'disponibilite' => $_POST['disponibilite'],
            'statut'        => intval($_POST['statut']),
            'photo'         => $photo_path,
            'user_id'       => $_SESSION['user_id'] 
        ];

      $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
      if ($offerModel->updateOffer($id, $data, $isAdmin)) {
    $_SESSION['success'] = "Annonce mise à jour !";
} else {
    $_SESSION['error'] = "Erreur de mise à jour.";
}

$redirect = $_SESSION['previous_url'] ?? '/mesoffres';
header('Location: ' . $redirect);
exit;
    }
}
public function mesOffres() 
{
    // 1. Sécurité : Vérifier si l'utilisateur est bien connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user_id'];

    // 2. Instancier le modèle
    $offerModel = new Offers();

    // 3. Récupérer uniquement les offres de cet utilisateur
    // méthode getByUserId() du modèle Offers
    $myOffers = $offerModel->getByUserId($userId);

    // 4. Afficher la vue dédiée aux annonces de l'utilisateur
    render('mesoffres', [
        'title'  => 'Mes annonces - TroqueTout',
        'offers' => $myOffers
    ]);
}
}