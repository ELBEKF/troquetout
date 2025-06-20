<?php 
require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/offer.php'; 




class OffersController {

    public function index($pdo) {
        $offerModel = new Offers();
        $offers = $offerModel->findAll($pdo);

        render('homepage', [
            "title" => "Offre",
            "offers" => $offers,
        ]);
    }

    public function offerDetail($pdo, $id){
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$offerDetail = new offers();
$detail = $offerDetail->findOfferById($pdo,$id);

render('offerdetail',[
"title" => "detail",
"detail" => $detail
]);

    }
}
