<?php

require_once 'controllers/AdminController.php';
require_once 'controllers/ConnexionController.php';
require_once 'controllers/homecontroller.php';
require_once 'controllers/MessagesController.php';
require_once 'controllers/offersController.php';
require_once 'controllers/PropositionController.php';
require_once 'controllers/requestController.php';
require_once 'controllers/usersController.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$method = $_SERVER['REQUEST_METHOD'];



$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



$segments = explode('/', trim($uri, '/'));


if ($segments[0] == "") {
    if ($method == "GET") {
        $controller = new HomeController();
        $controller->index();
    }
}

if (isset($segments[0]) && $segments[0] == "offers" && isset($segments[1]) && $segments[1] == "detail") {
    if ($method == "GET") {
        $controller = new OffersController();
        $id = isset($segments[2]) ? intval($segments[2]) : 0;
        $controller->offerDetail($id);
    }
}

if ($segments[0] == "connexion") {
    $controller = new ConnexionController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->handleLogin();
    } else {
        $controller->showForm();
    }
}

if ($segments[0] == "deconnexion") {
    
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit;
    
}

if ($segments[0] == "inscription") {
    $controller = new UsersController();
    $controller->register(); // gère GET et POST en interne
}

if ($segments[0] == "demandes") {
    if ($method == "GET") {
       $requestController = new RequestController();

$action = $_GET['action'] ?? 'listRequests';

switch ($action) {
    case 'createRequest':
        $requestController->create();
        break;

    case 'editRequest':
        if (isset($_GET['id'])) {
            $requestController->update($_GET['id']);
        } else {
            echo "ID manquant pour modification.";
        }
        break;

    case 'deleteRequest':
        if (isset($_GET['id'])) {
            $requestController->delete($_GET['id']);
        } else {
            echo "ID manquant pour suppression.";
        }
        break;

    case 'listRequests':
    default:
        $requestController->index();
        break;
}
    }
}

if ($segments[0] == "mesoffres") {
    if ($method == "GET") {
        $controller = new OffersController();
        $controller->mesOffres(); 
    }
}

if ($segments[0] == "contact") {
// session_start();

render('contact', [
    'title' => 'Contactez-nous'
]);

}

if ($segments[0] == "mesdemandes") {
    if ($method == "GET") {
        $controller = new RequestController();
        $controller->mesDemandes(); 
    }
}
if ($segments[0] == "mesfavoris") {
    if ($method == "GET") {
        $controller = new OffersController();
        $controller->favoris();
    }
}

if ($segments[0] == "messages_recus") {
    if ($method == "GET") {
        // session_start();
        $controller = new MessagesController();
        $controller->receivedMessages();
    }
}

if ($segments[0] === "admin" && isset($segments[1]) && $segments[1] === "modifUser" && isset($segments[2]) && is_numeric($segments[2])) {
    // Vérification sécurité admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: /');
        exit;
    }

    $controller = new AdminController();
    $userId = intval($segments[2]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupère et sécurise les données du formulaire
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $code_postal = trim($_POST['code_postal'] ?? '');

        $success = $controller->updateUser($userId, $nom, $prenom, $email, $telephone, $ville, $code_postal);

        if ($success) {
            $_SESSION['success'] = "Utilisateur modifié avec succès.";
            header('Location: /admin');
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la modification.";
            // Pour réafficher le formulaire avec les données postées en cas d'erreur
            $user = [
                'id' => $userId,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'ville' => $ville,
                'code_postal' => $code_postal,
            ];
            render('modifUser', [
                'user' => $user, 
                'error' => $_SESSION['error'],
                'title' => 'Modifier Utilisateur'
            ]);
            exit;
        }
    } else {
        // GET : afficher le formulaire avec les données actuelles
        if ($userId <= 0) {
            header('Location: /admin');
            exit;
        }

        $user = $controller->getUserById($userId);

        if (!$user) {
            $_SESSION['error'] = "Utilisateur introuvable.";
            header('Location: /admin');
            exit;
        }

        render('modifUser', [
            'user' => $user, 
            'error' => '',
            'title' => 'Modifier Utilisateur'
        ]);
    }
    exit;
}



if ($segments[0] == "admin") {
    if ($method == "GET") {
// Vérification de sécurité :

// On vérifie si l'utilisateur est connecté (user_id présent en session)
// et si son rôle est bien "admin"
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Si ce n'est pas un admin, on le redirige vers la page d'accueil
    header('Location: /'); // Redirection
    exit;                 // On arrête le script ici
}

// ==========================
// Appel du contrôleur Admin
// ==========================
// On crée un objet AdminController
$controller = new AdminController();

// On appelle la méthode dashboard() pour afficher la page admin
// et on lui passe $pdo (connexion à la base)
$controller->dashboard();
    }
}

if ($segments[0] === "profil" && isset($segments[1]) && $segments[1] === "modifProfil") {
    // session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: /connexion");
        exit;
    }

    $userModel = new Users();
    $userId = $_SESSION['user_id'];
    $method = $_SERVER['REQUEST_METHOD'];
    $error = '';
    $user = [];

    if ($method === 'POST') {
        // Récupération et nettoyage des données du formulaire
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $ville = trim($_POST['ville'] ?? '');
        $code_postal = trim($_POST['code_postal'] ?? '');

        // Mise à jour de l'utilisateur
        $success = $userModel->updateUser($userId, $nom, $prenom, $email, $telephone, $ville, $code_postal);

        if ($success) {
            $_SESSION['success'] = "Profil mis à jour avec succès.";
            header('Location: /profil');
            exit;
        } else {
            $error = "Erreur lors de la mise à jour.";
            // On renvoie les données saisies pour les réafficher dans le formulaire
            $user = [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'ville' => $ville,
                'code_postal' => $code_postal
            ];
        }
    } else {
        // En GET : on récupère les données actuelles de l'utilisateur
        $user = $userModel->readProfil($userId);
    }

    // Rendu de la vue du formulaire de modification
    render('modifProfil', [
        'user' => $user,
        'error' => $error,
        'title' => 'Modifier mon profil'
    ]);
    exit; // ← Important : stoppe l'exécution du script ici
}

if ($segments[0] == "profil") {
    if ($method == "GET") {
        $controller = new UsersController();
        $controller->profil();
    }
}

if ($segments[0] === "offers" && isset($segments[1]) && $segments[1] === "addOffer") {
    $controller = new OffersController();
    $controller->handleAddOffer(); 
    exit;
}

if ($segments[0] === "deleteOffer" && isset($segments[1]) && is_numeric($segments[1])) {
    $controller = new OffersController();
    $controller->delete(intval($segments[1]));
    exit;
}

if (isset($segments[0], $segments[1], $segments[2]) && ($segments[0] === "offers" || $segments[0] === "mesoffres") && $segments[1] === "modifoffer" &&
 is_numeric($segments[2])
) {
    $controller = new OffersController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->updateoffer();
    } else {
        $controller->modifoffer(intval($segments[2]));
    }

    exit;
}


if ($segments[0] === "deleteUser" && isset($segments[1]) && is_numeric($segments[1])) {
    $controller = new AdminController();
    $controller->deleteUser( intval($segments[1]) );
    header("Location: /admin");
    exit;
}


// if ($segments[0] == "addfavoris") {
//     if ($method == "GET") {
//         $controller = new OffersController();
//         $controller->addFavori();
//     }
// }

if (isset($segments[0]) && $segments[0] == "offers" && isset($segments[1]) && $segments[1] == "addfavoris") {
        if ($method == "POST") {
        $controller = new OffersController();
        $controller->addFavori();
}

    }

if (isset($segments[0]) && $segments[0] == "mesfavoris" && isset($segments[1]) && $segments[1] == "togglefavoris") {
        if ($method == "POST") {
                    // Instancie ton contrôleur
            $controller = new OffersController();

            // Appelle la méthode toggleFavoris en lui passant la connexion PDO
            $controller->toggleFavoris();
}

    }

    
if ($segments[0] === "demande" && isset($segments[1]) && $segments[1] === "create") {
    $requestController = new RequestController();
$requestController->create();
    exit;
}

if ($segments[0] == "deletedemande" && isset($segments[1]) && is_numeric($segments[1])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requestController = new RequestController();
        $requestController->delete((int)$segments[1]);
        exit;
    } else {
        header('Location: /demandes');
        exit;
    }
}

if ($segments[0] === "demande" && $segments[1] === "editdemande" && isset($segments[2]) && is_numeric($segments[2])) {
    $requestController = new RequestController();
    $requestController->update((int)$segments[2]); 
}

if ($segments[0] === "demande" && $segments[1] === "proposer" && isset($segments[2]) && is_numeric($segments[2])) {
    // require_once 'controllers/PropositionController.php';
    $controller = new PropositionController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->envoyer();
    } else {
        // tu passes l'id dans la méthode form()
        $controller->form(intval($segments[2]));
    }
    exit;
}

if ($segments[0] === "demande" && $segments[1] === "proposer" && isset($segments[2]) && is_numeric($segments[2])) {
   if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour envoyer un message.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $toUserId = intval($_POST['to_user_id'] ?? 0);
    $offerId = intval($_POST['offer_id'] ?? 0);
    $messageText = trim($_POST['message'] ?? '');

    if ($toUserId && $offerId && !empty($messageText)) {
        $messageModel = new Message();
        $success = $messageModel->sendMessage( $_SESSION['user_id'], $toUserId, $offerId, $messageText);

        if ($success) {
            header("Location: offerdetail.php?id=$offerId&sent=1");
            exit;
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
}


if ($segments[0] === "send_message") {
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté pour envoyer un message.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $toUserId = intval($_POST['to_user_id'] ?? 0);
        $offerId = intval($_POST['offer_id'] ?? 0);
        $messageText = trim($_POST['message'] ?? '');

        if ($toUserId && $offerId && !empty($messageText)) {
            require_once __DIR__ . '/model/message.php';
            $messageModel = new Message();

            $success = $messageModel->sendMessage(
                $_SESSION['user_id'],
                $toUserId,
                $offerId,
                $messageText
            );

            if ($success) {
                header("Location: /messages_recus");
                exit;
            } else {
                echo "Erreur lors de l'envoi du message.";
            }
        } else {
            echo "Tous les champs sont obligatoires.";
        }
    }
}

if ($segments[0] === 'sendcontact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/phpmailer/PHPMailer-6.10.0/src/Exception.php';
    require_once __DIR__ . '/phpmailer/PHPMailer-6.10.0/src/PHPMailer.php';
    require_once __DIR__ . '/phpmailer/PHPMailer-6.10.0/src/SMTP.php';

    

    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($nom && $email && $message) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['contact_success'] = "L'adresse email n'est pas valide.";
        } else {
            $email = str_replace(["\r", "\n"], '', $email);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'faycaltroquetout@gmail.com';
                $mail->Password = 'juis jxyx xngn irpd';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                $mail->setFrom('faycaltroquetout@gmail.com', 'TroqueTout');
                $mail->addReplyTo($email, $nom);
                $mail->addAddress('faycaltroquetout@gmail.com');

                $mail->isHTML(false);
                $mail->Subject = 'Nouveau message depuis le troquetout';
                $mail->Body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";

                $mail->send();
                $_SESSION['contact_success'] = "Votre message a été envoyé avec succès !";
            } catch (Exception $e) {
                $_SESSION['contact_success'] = "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        }
    } else {
        $_SESSION['contact_success'] = "Veuillez remplir tous les champs.";
    }

    header("Location: /contact");
    exit;
}

