<?php 
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/offer.php'; 

class OffersController {

   public function index($pdo)
{
    $search = $_GET['search'] ?? '';
    $type = $_GET['type'] ?? '';
    $etat = $_GET['etat'] ?? '';
    $localisation = $_GET['localisation'] ?? '';
    $sort = $_GET['sort'] ?? 'desc';


    $offerModel = new Offers();
    $offers = $offerModel->findWithFilters($pdo, $search, $type, $etat, $localisation, $sort);

    render('homepage', [
        "title" => "Offres",
        "offers" => $offers,
        "search" => $search,
        "type" => $type,
         "etat" => $etat,
        "localisation" => $localisation,
        "sort" => $sort,
    ]);
}



    public function offerDetail($pdo, $id){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $offerDetail = new Offers();
        $detail = $offerDetail->findOfferById($pdo, $id);

        render('offerdetail', [
            "title" => "detail",
            "detail" => $detail
        ]);
    }

  public function handleAddOffer($pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
echo "<pre>";
print_r($_POST);
echo "</pre>";

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
                )


             {
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

                if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $addOffer->setUserId($_SESSION['user_id']);
} else {
    echo "Vous devez être connecté pour ajouter une offre.";
    exit;
}

if ($addOffer->addOffers($pdo)) {
    header("Location: /offers.php");
    exit;
} else {
    echo "Erreur lors de l'ajout de l'offre";
}
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }

        render('addOffers', [
            "title" => "Ajout d'une offre"
        ]);
    }

public function delete($pdo, $id)
{
    session_start();

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        echo "Accès non autorisé.";
        exit;
    }

    $offerModel = new Offers();
    $offer = $offerModel->findOfferById($pdo, $id);

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
    $offerModel->deleteOffer($pdo, $id);

    // Redirige vers la page précédente si possible, sinon vers une page par défaut
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /offers.php"); // page par défaut
    }
    exit;
}




public function modifoffer($pdo, $id)
{
    $id = intval($id);
    $offerModel = new Offers();
    $row = $offerModel->findOfferById($pdo, $id);

    render('modifOffer', [
        "title" => "Modifier l'offre",
        "modif" => $row
    ]);
}
public function updateoffer($pdo)
{
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

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

    $offer = new Offers($data);
    if ($offer->updateOfferInDb($pdo, $id)) {
        header("Location: /offers.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}

public function mesOffres($pdo) {
    if (!isset($_SESSION['user_id'])) {
        echo "Erreur : vous devez être connecté pour voir vos offres.";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $offerModel = new Offers();
    $offers = $offerModel->getByUserId($pdo, $userId);

    render('mesoffres', [
        'title' => 'Mes offres',
        'offers' => $offers
    ]);
}


public function addFavori($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offer_id'])) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $offerId = intval($_POST['offer_id']);

        $offerModel = new Offers();
        $offerModel->addFavori($pdo, $userId, $offerId);

        // Redirection vers la page précédente ou les favoris
        header("Location: mesfavoris.php" );
        exit;
    }
}
public function favoris($pdo)
{
    if (!isset($_SESSION['user_id'])) {
        // Rediriger vers la page login si pas connecté
        header("Location: /login.php");
        exit;
    }

    $userId = $_SESSION['user_id'];
    $offerModel = new Offers();
    $favoris = $offerModel->getFavorisByUser($pdo, $userId);

    render('mesfavoris', [  // on appelle ici la vue mesfavoris.php
        'title' => 'Mes favoris',
        'offers' => $favoris
    ]);
}


}
