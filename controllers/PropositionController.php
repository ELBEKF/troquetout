<?php

require_once dirname(__DIR__) . '/model/Proposition.php';
require_once dirname(__DIR__) . '/model/Offers.php';
require_once dirname(__DIR__) . '/model/Message.php';
require_once dirname(__DIR__) . '/config/render.php';

class PropositionController {

 
    public function form($requestId) {
    // 1. Vérification de la session (Toujours en premier pour la sécurité)
    if (!isset($_SESSION['user_id'])) {
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user_id'];

    // 2. Instanciation du modèle
    $offerModel = new Offers();
    
    // 3. Récupération des données
    $offres = $offerModel->getByUserId($userId); 

    render('proposer_offre', [
        'title'      => 'Proposer une offre',
        'request_id' => intval($requestId), 
        'offres'     => $offres,
        'error'      => ''
    ]);
    }

    /**
     * Traite l'envoi de la proposition et du message associé
     */
    public function envoyer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
            if (!isset($_SESSION['user_id'])) {
                header('Location: /connexion');
                exit;
            }

            $offreurId  = $_SESSION['user_id'];
            $requestsId = intval($_POST['request_id']);
            $offreId    = intval($_POST['offre_id'] ?? 0);
            $message    = trim($_POST['message'] ?? '');

            if (empty($message) || $offreId === 0) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header("Location: /demande/proposer/" . $requestsId);
                exit;
            }

            // 1. Enregistrer la proposition via le modèle
            $propositionModel = new Proposition();
            $propositionModel->save($offreurId, $requestsId, $offreId, $message);

            // 2. Récupérer le propriétaire de la demande via le modèle Request
            require_once dirname(__DIR__) . '/model/Request.php';
            $requestModel = new Request();
            $requestData  = $requestModel->getById($requestsId);

            if (!$requestData) {
                $_SESSION['error'] = "Demande introuvable.";
                header("Location: /demandes");
                exit;
            }

            // 3. Envoyer le message de notification au demandeur
            $messageModel = new Message();
            $messageModel->sendMessage($offreurId, $requestData['user_id'], $offreId, $message);

            $_SESSION['success'] = "Votre proposition a été envoyée !";
            header("Location: /messages_recus");
            exit;
        }
    }
}