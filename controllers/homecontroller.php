<?php
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/Offers.php';

class HomeController {

    public function index() {

        $search = $_GET['search'] ?? '';
        $type = $_GET['type'] ?? '';
        $etat = $_GET['etat'] ?? '';
        $localisation = $_GET['localisation'] ?? '';
        $sort = $_GET['sort'] ?? 'desc';

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
    public function indexAjax() {
    $search       = $_GET['search'] ?? '';
    $type         = $_GET['type'] ?? '';
    $etat         = $_GET['etat'] ?? '';
    $localisation = $_GET['localisation'] ?? '';
    $sort         = $_GET['sort'] ?? 'desc';
    $userId       = $_SESSION['user_id'] ?? null;

    $offerModel = new Offers();
    $offers = $offerModel->findWithFiltersAndFavoris($search, $type, $etat, $localisation, $sort, $userId);

    header('Content-Type: text/html; charset=utf-8');
    include dirname(__DIR__) . '/views/partials/offers_list.php';
    exit;
}
}
