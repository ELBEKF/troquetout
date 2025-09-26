<?php 
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/offer.php'; 

class OffersController {

    private $data = [];

    public function __construct($data = []) {
        $this->data = $data;
    }



   public function index()
{
    // S'assurer que la session est démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $search = $_GET['search'] ?? '';
    $type = $_GET['type'] ?? '';
    $etat = $_GET['etat'] ?? '';
    $localisation = $_GET['localisation'] ?? '';
    $sort = $_GET['sort'] ?? 'desc';

    $offerModel = new Offers();
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Utiliser la nouvelle méthode qui récupère directement le statut favori
    $offers = $offerModel->findWithFiltersAndFavoris($search, $type, $etat, $localisation, $sort, $userId);

    render('homepage', [
        "title" => "Accueil - TroqueTout",
        "offers" => $offers,
        "search" => $search,
        "type" => $type,
        "etat" => $etat,
        "localisation" => $localisation,
        "sort" => $sort,
    ]);
}

    public function offerDetail($id){
    // Ne pas écraser $id ici, utilise simplement le paramètre reçu
    $offerDetail = new Offers();
    $detail = $offerDetail->findOfferById($id);

    // Vérifie que l'offre existe avant de continuer
    if (!$detail) {
        // Offre non trouvée, gérer l'erreur, afficher message ou page 404
        echo "Offre non trouvée.";
        exit;
    }

    render('offerdetail', [
        "title" => "detail",
        "detail" => $detail
    ]);
}


  public function handleAddOffer()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérification des champs
        if (
            !empty($_POST["titre"]) &&
            !empty($_POST["description"]) &&
            !empty($_POST["sens"]) &&
            !empty($_POST["type"]) &&
            !empty($_POST["categorie"]) &&
            !empty($_POST["etat"]) &&
            isset($_POST["prix"]) &&
            isset($_POST["caution"]) &&
            !empty($_POST["localisation"]) &&
            !empty($_POST["photo"]) &&
            !empty($_POST["disponibilite"]) &&
            isset($_POST["statut"])
        ) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user_id'])) {
                echo "Vous devez être connecté pour ajouter une offre.";
                exit;
            }

            $addOffer = new Offers();
            $addOffer->setTitre($_POST["titre"]);
            $addOffer->setDescription($_POST["description"]);
            $addOffer->setSens($_POST["sens"]);
            $addOffer->setType($_POST["type"]);
            $addOffer->setCategorie($_POST["categorie"]);
            $addOffer->setEtat($_POST["etat"]);
            $addOffer->setPrix($_POST["prix"]);
            $addOffer->setCaution($_POST["caution"]);
            $addOffer->setLocalisation($_POST["localisation"]);
            $addOffer->setPhoto($_POST["photo"]);
            $addOffer->setDisponibilite($_POST["disponibilite"]);
            $addOffer->setStatut($_POST["statut"]);
            $addOffer->setUserId($_SESSION['user_id']);

            if ($addOffer->addOffers()) {
                header("Location: /");
                exit;
            } else {
                $error = "Erreur lors de l'ajout de l'offre.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }

        // En cas d'erreur en POST, on affiche à nouveau le formulaire avec un message
        render('addOffers', [
            "title" => "Ajout d'une offre",
            "error" => $error ?? ''
        ]);

    } else {
        // Requête GET → afficher le formulaire vide
        render('addOffers', [
            "title" => "Ajout d'une offre"
        ]);
    }
}


public function delete( $id)
{
    session_start();

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        echo "Accès non autorisé.";
        exit;
    }

    $offerModel = new Offers();
    $offer = $offerModel->findOfferById($id);

    // Vérifie si l'offre existe
    if (!$offer) {
        echo "Offre non trouvée.";
        exit;
    }

    // Vérifie si l'utilisateur est le propriétaire de l'offre ou un admin
    if ($_SESSION['user_id'] != $offer['user_id'] && ($_SESSION['user_role'] ?? '') !== 'admin') {
        echo "Vous n'avez pas la permission de supprimer cette offre.";
        exit;
    }

    // Suppression autorisée
    $offerModel->deleteOffer( $id);

    // Redirige vers la page précédente si possible, sinon vers une page par défaut
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /offers"); // page par défaut
    }
    exit;
}




public function modifoffer( $id)
{
    $id = intval($id);
    $offerModel = new Offers();
    $row = $offerModel->findOfferById( $id);

    render('modifOffer', [
        "title" => "Modifier l'offre",
        "modif" => $row
    ]);
}
public function updateoffer()
{
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Récupérer les données du formulaire dans un tableau
    $data = [
        'titre'         => $_POST['titre'] ?? '',
        'description'   => $_POST['description'] ?? '',
        'sens'          => $_POST['sens'] ?? '',
        'type'          => $_POST['type'] ?? '',
        'categorie'     => $_POST['categorie'] ?? '',
        'etat'          => $_POST['etat'] ?? '',
        'prix'          => $_POST['prix'] ?? 0,
        'caution'       => $_POST['caution'] ?? 0,
        'localisation'  => $_POST['localisation'] ?? '',
        'photo'         => $_POST['photo'] ?? '',
        'disponibilite' => $_POST['disponibilite'] ?? '',
        'statut'        => $_POST['statut'] ?? 1,
    ];

    $offer = new Offers();

    // Affecter les valeurs aux propriétés de l'objet
    $offer->setTitre($data['titre']);
    $offer->setDescription($data['description']);
    $offer->setSens($data['sens']);
    $offer->setType($data['type']);
    $offer->setCategorie($data['categorie']);
    $offer->setEtat($data['etat']);
    $offer->setPrix($data['prix']);
    $offer->setCaution($data['caution']);
    $offer->setLocalisation($data['localisation']);
    $offer->setPhoto($data['photo']);
    $offer->setDisponibilite($data['disponibilite']);
    $offer->setStatut($data['statut']);

    // Appeler la méthode de mise à jour avec l'id
    if ($offer->updateOfferInDb($id)) {
        header("Location: /");
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}


public function mesOffres() {
    if (!isset($_SESSION['user_id'])) {
        echo "Erreur : vous devez être connecté pour voir vos offres.";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $offerModel = new Offers();
    $offers = $offerModel->getByUserId($userId);

    render('mesoffres', [
        'title' => 'Mes offres',
        'offers' => $offers
    ]);
}


public function addFavori()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offer_id'])) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /connexion");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $offerId = intval($_POST['offer_id']);

        $offerModel = new Offers();
        
        // Utiliser toggleFavoris au lieu de addFavori pour gérer l'ajout/suppression
        $isNowInFavoris = $offerModel->toggleFavoris($userId, $offerId);

        // Optionnel : message flash pour informer l'utilisateur
        $_SESSION['flash_message'] = $isNowInFavoris ? "Offre ajoutée aux favoris." : "Offre retirée des favoris.";
        $_SESSION['flash_type'] = $isNowInFavoris ? "success" : "warning";

        // Redirection vers la page précédente ou l'accueil
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: " . $redirect);
        exit;
    }
}
public function favoris()
{
    if (!isset($_SESSION['user_id'])) {
        // Rediriger vers la page login si pas connecté
        header("Location: /connexion");
        exit;
    }

    $userId = $_SESSION['user_id'];
    $offerModel = new Offers();
    $favoris = $offerModel->getFavorisByUser($userId);

    render('mesfavoris', [  // on appelle ici la vue mesfavoris.php
        'title' => 'Mes favoris',
        'offers' => $favoris
    ]);
}

public function toggleFavoris() {
    session_start();

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
    $inFavoris = $offerModel->toggleFavoris( $userId, $offerId);

    $_SESSION['flash_message'] = $inFavoris ? "Offre ajoutée aux favoris." : "Offre retirée des favoris.";
    $_SESSION['flash_type'] = $inFavoris ? "success" : "warning";

    $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
    header('Location: ' . $redirect);
    exit;
}


}