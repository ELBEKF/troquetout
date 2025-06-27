<?php 
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/offer.php'; 

class OffersController {

   public function index($pdo)
{
    $search = $_GET['search'] ?? '';
    $type = $_GET['type'] ?? '';

    $offerModel = new Offers();
    $offers = $offerModel->findWithFilters($pdo, $search, $type);

    render('homepage', [
        "title" => "Offres",
        "offers" => $offers,
        "search" => $search,
        "type" => $type,
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
        $offerModel = new Offers();
        $offerModel->deleteOffer($pdo, $id);
        header("Location: /offers.php");
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

}
