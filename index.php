<?php

session_start();
if (isset($_SESSION['user_id'])) {
    require_once 'model/message.php';
    $msg = new Message();
    $_SESSION['unread_count'] = $msg->countUnread((int)$_SESSION['user_id']);
}
require_once 'controllers/AdminController.php';
require_once 'controllers/ConnexionController.php';
require_once 'controllers/HomeController.php';      
require_once 'controllers/MessagesController.php';
require_once 'controllers/OffersController.php';     
require_once 'controllers/PropositionController.php';
require_once 'controllers/RequestController.php';    
require_once 'controllers/UsersController.php';      

// 3. Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 4. Analyse de l'URL
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));

if ($segments[0] == "") {
    if ($method == "GET") {
        $controller = new HomeController();

        //  Détecte si c'est une requête AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $controller->indexAjax(); // Renvoie uniquement le fragment HTML
            exit;
        }

        $controller->index(); // Renvoie la page complète normalement
        exit;
    }
}

// --- ROUTAGE CONNEXION / DECONNEXION ---
if ($segments[0] == "connexion") {
    $controller = new ConnexionController();
    $method === 'POST' ? $controller->handleLogin() : $controller->showForm();
    exit;
}

if ($segments[0] == "deconnexion") {
    $_SESSION = [];
    session_destroy();
    header("Location: /");
    exit;
}

if ($segments[0] == "inscription") {
    $controller = new UsersController();
    $controller->register();
    exit;
}

if ($segments[0] == "offers") {
    $controller = new OffersController();
    if (isset($segments[1])) {
        switch ($segments[1]) {
            case 'detail':
                $id = isset($segments[2]) ? intval($segments[2]) : 0;
                $controller->offerDetail($id);
                break;
            case 'addOffer':
                $controller->handleAddOffer();
                break;
            case 'addfavoris':
                if ($method == "POST") { $controller->addFavori(); }
                break;
            case 'modifoffer':
                $id = isset($segments[2]) ? intval($segments[2]) : 0;
                $method === 'POST' ? $controller->updateoffer() : $controller->modifoffer($id);
                break;
            case 'updateoffer':
                if ($method == "POST") { $controller->updateoffer(); }
                break;
            case 'delete':
                $id = isset($segments[2]) ? intval($segments[2]) : 0;
                $controller->delete($id);
                break;
        }
        exit; // ✅ ici, après le switch
    }
}

// --- ROUTAGE ESPACE PERSO ---
if ($segments[0] == "mesoffres") {
    $controller = new OffersController();
    $controller->mesOffres();
    exit;
}

if ($segments[0] == "mesdemandes") {
    $controller = new RequestController();
    $controller->mesDemandes();
    exit;
}

if ($segments[0] == "mesfavoris") {
    $controller = new OffersController();
    // Gère l'affichage de la liste OU le retrait d'un favori
    if (isset($segments[1]) && $segments[1] == "togglefavoris") {
        $controller->addFavori(); 
    } else {
        $controller->favoris();
    }
    exit;
}

// index.php

// Route pour l'affichage ET la modification du profil
if ($segments[0] === "profil") {
    $controller = new UsersController();
    
    // Si on a /profil/modifProfil
    if (isset($segments[1]) && $segments[1] === "modifProfil") {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateProfil();
        } else {
            $controller->modifProfil();
        }
    } 
    // Si on a juste /profil
    else {
        $controller->profil();
    }
    exit;
}

// --- ROUTAGE MESSAGERIE ---
if ($segments[0] == "messages_recus") {
    $controller = new MessagesController();
    $controller->receivedMessages();
    exit;
}

// index.php

if ($segments[0] === "send_message") {
    // On instancie le bon contrôleur
    $controller = new MessagesController();
    // On appelle la méthode send() (qui existe dans ton MessagesController)
    $controller->send();
    exit;
}

// --- ROUTAGE DEMANDES (Besoins) ---
if ($segments[0] == "demandes") {
    $controller = new RequestController();
    $controller->index();
    exit;
}

if ($segments[0] === "demande") {
    $controller = new RequestController();
    if (isset($segments[1])) {
        switch ($segments[1]) {
            case 'create':
                $controller->create();
                break;
            case 'editdemande':
                $controller->update(intval($segments[2]));
                break;
            case 'proposer': // Répondre à une demande avec une offre
                $propController = new PropositionController();
                $id = intval($segments[2]);
                $method === 'POST' ? $propController->envoyer() : $propController->form($id);
                break;
        }
        exit;
    }
}

// --- ROUTAGE ADMIN ---
if ($segments[0] == "admin") {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: /');
        exit;
    }
    $controller = new AdminController();
    
    if (isset($segments[1]) && $segments[1] === "modifUser" && isset($segments[2])) {
        $id = intval($segments[2]);
        $method === 'POST' ? $controller->updateUser($id) : $controller->modifUser($id);
    } else if (isset($segments[1]) && $segments[1] === "deleteUser" && isset($segments[2])) {
        $controller->deleteUser(intval($segments[2]));
    // ✅ Ajoute juste ce cas
    } else if (isset($segments[1]) && $segments[1] === "deleteOffer" && isset($segments[2])) {
        $controller->deleteOffer(intval($segments[2]));
    } else {
        $controller->dashboard();
    }
    exit;
}

// --- ROUTAGE CONTACT & PHPMailer ---
if ($segments[0] == "contact") {
    render('contact', ['title' => 'Contactez-nous']);
    exit;
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


// --- SI AUCUNE ROUTE NE CORRESPOND (404) ---
header("HTTP/1.0 404 Not Found");
echo "Page non trouvée";