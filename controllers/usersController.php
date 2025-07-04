<?php

require_once dirname(__DIR__).'/config/database.php';
require_once dirname(__DIR__) . '/config/render.php';
require_once dirname(__DIR__) . '/model/User.php'; 
class UsersController
{
    public function register($pdo)
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $ville = $_POST['ville'] ?? '';
            $code_postal = $_POST['code_postal'] ?? '';

            // Validation simple
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } else {
                // Vérifier si email existe déjà (ajoute cette méthode dans Users si besoin)
                if ($this->emailExists($pdo, $email)) {
                    $error = 'Cet email est déjà utilisé.';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    // Créer un nouvel utilisateur
                    $user = new Users(
                        $nom,
                        $prenom,
                        $email,
                       $hashedPassword, // mot de passe hashé
                        'utilisateur',
                        $telephone,
                        $ville,
                        $code_postal,
                        date('Y-m-d H:i:s')
                    );

                    $id = $user->addUsers($pdo);

                    if ($id) {
                        // Inscription OK, redirection vers connexion ou autre
                        header('Location: connexion.php');
                        exit;
                    } else {
                        $error = 'Une erreur est survenue lors de l\'inscription.';
                    }
                }
            }
        }

        render('inscription', [
            'title' => 'Inscription',
            'error' => $error
        ]);
    }

    private function emailExists($pdo, $email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function profil($pdo)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit;
        }

        $userModel = new Users();
        $profil = $userModel->readProfil($pdo, $_SESSION['user_id']);

        render('profil', [
            "title" => "Mon profil",
            "profil" => $profil
        ]);
    }
    public function updateProfil($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $ville = $_POST['ville'] ?? '';
        $code_postal = $_POST['code_postal'] ?? '';

        $userModel = new Users();
        $userModel->updateUser($pdo, $id, $nom, $prenom, $email, $telephone, $ville, $code_postal);

        header('Location: /modifUser.php');
        exit;
    }

    echo "Erreur : formulaire invalide.";
}

}
