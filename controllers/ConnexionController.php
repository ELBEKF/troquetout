<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/render.php'; // inclure ta fonction render
require_once __DIR__ . '/../model/User.php';

class ConnexionController {
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
    public function showForm() {
        // Récupérer l'erreur en session si elle existe
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        // Utiliser render en passant les variables nécessaires
        render('connexion', [
            'title' => 'Connexion',
            'error' => $error
        ]);
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['inputEmail'] ?? '';
            $password = $_POST['inputMdp'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Les champs sont vides, veuillez les remplir !";
                header('Location: /connexion');
                exit;
            }

            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_role'] = $user['role'];

                header('Location: /');
                exit;
            } else {
                $_SESSION['error'] = "L'identifiant et/ou mot de passe est incorrect !";
                header('Location: /connexion');
                exit;
            }
        }
    }
}
