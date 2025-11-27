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
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        render('addOffers', ["title" => "Ajout d'une offre"]);
        return;
    }

    // session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté pour ajouter une offre.";
        exit;
    }

    // champs obligatoires
    $requiredFields = [
        'titre', 'description', 'sens', 'type', 'categorie',
        'etat', 'prix', 'caution', 'localisation',
        'disponibilite', 'statut'
    ];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field]) && $_POST[$field] !== "0") {
            $error = "Veuillez remplir tous les champs.";
            render('addOffers', ["title" => "Ajout d'une offre", "error" => $error]);
            return;
        }
    }

    // vérification fichier
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $error = "Veuillez ajouter une photo valide.";
        render('addOffers', ["title" => "Ajout d'une offre", "error" => $error]);
        return;
    }

    // infos fichier
    $tmp_name = $_FILES['photo']['tmp_name'];
    $original = basename($_FILES['photo']['name']);
    $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowed)) {
        $error = "Extension de fichier non autorisée. (jpg,jpeg,png,gif,webp)";
        render('addOffers', ["title" => "Ajout d'une offre", "error" => $error]);
        return;
    }

    // --- CHEMINS ROBUSTES ---
    // project root (dossier troquetout)
    $projectRoot = realpath(dirname(__DIR__)); // controllers/.. => troquetout
    if ($projectRoot === false) {
        render('addOffers', ["title" => "Ajout d'une offre", "error" => "Impossible de déterminer le chemin du projet."]);
        return;
    }

    // dossier public physique
    $publicDir = $projectRoot . DIRECTORY_SEPARATOR . 'public';
    $uploadDir = $publicDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'offers' . DIRECTORY_SEPARATOR;

    // crée dossier si nécessaire
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        render('addOffers', ["title" => "Ajout d'une offre", "error" => "Impossible de créer le dossier d'upload ($uploadDir). Vérifiez les permissions."]);
        return;
    }

    // nom de fichier unique
    $filename = uniqid('offer_') . '.' . $extension;
    $finalPath = $uploadDir . $filename;

    // déplacer le fichier uploadé
    if (!move_uploaded_file($tmp_name, $finalPath)) {
        render('addOffers', ["title" => "Ajout d'une offre", "error" => "Erreur lors du déplacement du fichier sur le serveur."]);
        return;
    }

    // --- construire une URL publique fiable pour la BDD ---
    // essaie de déduire le chemin relatif depuis DOCUMENT_ROOT
    $publicDirReal = realpath($publicDir);
    $docRootReal = realpath($_SERVER['DOCUMENT_ROOT']);

    // Normalise séparateurs
    $publicDirNorm = $publicDirReal ? str_replace('\\', '/', $publicDirReal) : '';
    $docRootNorm = $docRootReal ? str_replace('\\', '/', $docRootReal) : '';

    if ($docRootNorm !== '' && strpos($publicDirNorm, $docRootNorm) === 0) {
        // cas classique : public est sous DOCUMENT_ROOT
        $publicUrlBase = substr($publicDirNorm, strlen($docRootNorm));
        // ensure leading slash
        if ($publicUrlBase === '' || $publicUrlBase[0] !== '/') {
            $publicUrlBase = '/' . ltrim($publicUrlBase, '/');
        }
    } else {
        // fallback : si public est le docroot ou unknown, on prend empty string (URL '/uploads/offers/...')
        // si ton site est servi depuis /troquetout/public, alors $publicUrlBase sera '' et /uploads/... fonctionnera.
        // si ton site est servi depuis /troquetout (public non root), tu peux forcer la base (ex: '/troquetout/public')
        $publicUrlBase = '';
    }

    // url relative à stocker en BDD (ex: '/uploads/offers/offer_xxx.jpg' or '/troquetout/public/uploads/offers/offer_xxx.jpg')
    $photo_path = rtrim($publicUrlBase, '/') . '/uploads/offers/' . $filename;
    // s'assurer d'un leading slash
    if ($photo_path[0] !== '/') {
        $photo_path = '/' . $photo_path;
    }

    // --- CRÉATION DE L'OFFRE ---
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
    $addOffer->setPhoto($photo_path);
    $addOffer->setDisponibilite($_POST["disponibilite"]);
    $addOffer->setStatut($_POST["statut"]);
    $addOffer->setUserId($_SESSION['user_id']);

    // enregistrement en BDD
    if ($addOffer->addOffers()) {
        header("Location: /");
        exit;
    }

    // en cas d'erreur
    render('addOffers', ["title" => "Ajout d'une offre", "error" => "Erreur lors de l'enregistrement en base."]);
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