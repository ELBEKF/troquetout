<?php

require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/Offer.php';

class HomeController {

    public function index() {
        // NE PAS démarrer session ici, pour ne pas forcer la connexion
        // La session peut être démarrée dans la vue si besoin.

        $search = $_GET['search'] ?? '';
        $type = $_GET['type'] ?? '';
        $etat = $_GET['etat'] ?? '';
        $localisation = $_GET['localisation'] ?? '';
        $sort = $_GET['sort'] ?? 'desc';

        $offerModel = new Offers();
        $offers = $offerModel->findWithFilters( $search, $type, $etat, $localisation, $sort);

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
}
