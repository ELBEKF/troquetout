<?php
require_once dirname(__DIR__) . '/model/proposition.php';
require_once dirname(__DIR__) . '/config/render.php';

class PropositionController {

    private $pdo;

    public function __construct(){
// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=troquetout;charset=utf8";
$username = "root";
$password = "";

try {
    $this->pdo = new PDO($dsn, $username, $password, [
         // Activation des erreurs PDO (bonnes pratiques)
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
   
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}


}
    public function form($requestId)
{
    // session_start();

    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté.";
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Récupérer les offres de l'utilisateur connecté
    $sql = "SELECT id, titre FROM offers WHERE user_id = :userId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    render('proposer_offre', [
        'title' => 'Proposer une offre',
        'request_id' => $requestId,
        'offres' => $offres,
        'error' => ''
    ]);
}




    public function envoyer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // session_start();
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
        $propositionModel->save( $offreurId, $requestsId, $offreId, $message);

        // 2. Récupérer l'id du requestsur propriétaire de la requests (depuis ta table requestss)
        $stmt = $this->pdo->prepare("SELECT user_id FROM requests WHERE id = ?");
        $stmt->execute([$requestsId]);
        $requests = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$requests) {
            echo "requests non trouvée.";
            exit;
        }
        $requestsurId = $requests['user_id'];

        // 3. Envoyer un message au requestsur via ton modèle Message
        // require_once __DIR__ . '/../model/message';  // adapter le chemin selon ton arborescence
        $messageModel = new Message();
        $messageModel->sendMessage( $offreurId, $requestsurId, $offreId, $message);

        header("Location: /messages_recus");
        exit;
    }
}


}
