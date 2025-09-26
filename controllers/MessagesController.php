<?php 

// On importe les fichiers nécessaires
require_once dirname(__DIR__) . '/model/message.php'; // Modèle Message (pour interagir avec la BDD)
require_once dirname(__DIR__) . '/config/render.php'; // Fonction render() pour afficher les pages

// =======================
// Contrôleur Messages
// =======================
class MessagesController {
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
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
        }
    }

    // -------------------------------
    // Méthode : Afficher les messages reçus ET envoyés
    // -------------------------------
    public function receivedMessages() {
        // Vérifie si l'utilisateur est connecté (via session)
        if (!isset($_SESSION['user_id'])) {
            // Si pas connecté, on redirige vers la page de connexion
            header('Location: /login.php');
            exit;
        }

        // Récupère l'ID de l'utilisateur connecté depuis la session
        $userId = $_SESSION['user_id'];

        // On crée une instance du modèle Message
        $messageModel = new Message();

        // Récupère les messages destinés à cet utilisateur
        $receivedMessages = $messageModel->getMessagesForUser($userId);
        
        // Récupère les messages envoyés par cet utilisateur
        $sentMessages = $messageModel->getSentMessagesByUser($userId);

        // Affiche la page "messages_reçus" avec les messages reçus et envoyés
        render('messages_reçus', [
            'title' => 'Mes messages', // Titre de la page
            'messages' => $receivedMessages,     // Messages reçus
            'sent' => $sentMessages              // Messages envoyés
        ]);
    }

    // -------------------------------
    // Méthode : Envoyer un message
    // -------------------------------
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
                header("Location: /connexion");
                exit;
            }

            $fromUserId = $_SESSION['user_id'];
            $toUserId = intval($_POST['to_user_id'] ?? 0);
            $offerId = intval($_POST['offer_id'] ?? 0);
            $content = trim($_POST['message'] ?? '');

            if ($toUserId && $offerId && !empty($content)) {
                require_once __DIR__ . '/../model/message.php';
                $messageModel = new Message();

                $success = $messageModel->sendMessage($fromUserId, $toUserId, $offerId, $content);

                if ($success) {
                    // Rediriger vers les messages reçus (version route propre, sans .php)
                    header("Location: /messages/recus?success=1");
                    exit;
                } else {
                    echo "Erreur lors de l'envoi du message.";
                }
            } else {
                echo "Tous les champs sont obligatoires.";
            }
        } else {
            // Si la requête n'est pas POST, rediriger proprement
            header("Location: /");
            exit;
        }
    }
}