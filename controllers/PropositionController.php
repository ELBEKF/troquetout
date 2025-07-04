<?php
require_once dirname(__DIR__) . '/model/proposition.php';
require_once dirname(__DIR__) . '/config/render.php';

class PropositionController {
    public function form(PDO $pdo) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté.";
        exit;
    }

    if (!isset($_POST['request_id'])) {
        echo "requests non spécifiée.";
        exit;
    }

    $requestId = intval($_POST['request_id']);
    $userId = $_SESSION['user_id'];

    // Récupérer les offres de l'utilisateur connecté
    $sql = "SELECT id, titre FROM offers WHERE user_id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    render('proposer_offre', [
        'title' => 'Proposer une offre',
        'request_id' => $requestId,
        'offres' => $offres
    ]);
}


    public function envoyer($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "Vous devez être connecté.";
            exit;
        }

        $offreurId = $_SESSION['user_id'];
        $requestsId = intval($_POST['request_id']);
        $offreId = intval($_POST['offre_id'] ?? 0);
  // tu récupères l'id de l'offre liée à la proposition
        $message = trim($_POST['message'] ?? '');

        if (empty($message)) {
            echo "Le message est obligatoire.";
            exit;
        }

        if ($offreId === 0) {
            echo "Offre non spécifiée.";
            exit;
        }

        // 1. Enregistrer la proposition
        $propositionModel = new Proposition();
        $propositionModel->save($pdo, $offreurId, $requestsId, $offreId, $message);

        // 2. Récupérer l'id du requestsur propriétaire de la requests (depuis ta table requestss)
        $stmt = $pdo->prepare("SELECT user_id FROM requests WHERE id = ?");
        $stmt->execute([$requestsId]);
        $requests = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$requests) {
            echo "requests non trouvée.";
            exit;
        }
        $requestsurId = $requests['user_id'];

        // 3. Envoyer un message au requestsur via ton modèle Message
        require_once __DIR__ . '/../model/message.php';  // adapter le chemin selon ton arborescence
        $messageModel = new Message();
        $messageModel->sendMessage($pdo, $offreurId, $requestsurId, $offreId, $message);

        header("Location: messages_recus.php");
        exit;
    }
}


}
