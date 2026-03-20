<?php

require_once dirname(__DIR__) . '/model/Request.php';
require_once dirname(__DIR__) . '/config/render.php';

class RequestController {
    private $model;

    public function __construct() {
        $this->model = new Request();
    }

    /**
     * Affiche la liste de toutes les demandes
     */
    public function index() {
        $requests = $this->model->getAll();
        render('demande', [
            'title'    => 'Liste des demandes',
            'requests' => $requests
        ]);
    }

    /**
     * Traite la création d'une nouvelle demande
     */
    public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour créer une demande.";
            header('Location: /connexion');
            exit;
        }

        $data = [
            'user_id'      => $_SESSION['user_id'],
            'titre'        => trim($_POST['titre'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'type_demande' => $_POST['type_demande'] ?? '',
            'date_besoin'  => $_POST['date_besoin'] ?? date('Y-m-d') 
        ];

        if (empty($data['titre']) || empty($data['description']) || empty($data['type_demande'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires.";
            render('create', ['title' => 'Créer une demande']);
            return;
        }

        if ($this->model->create($data)) {
            $_SESSION['success'] = "Votre demande a été publiée avec succès.";
            header('Location: /demandes');
            exit;
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la création.";
        }
    }

    render('create', ['title' => 'Créer une demande']);
}

    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre'        => $_POST['titre'],
                'description'  => $_POST['description'],
                'type_demande' => $_POST['type_demande'],
                'date_besoin'  => $_POST['date_besoin'],
                'user_id'      => $_SESSION['user_id']
            ];

            if ($this->model->update($id, $data)) {
                $_SESSION['success'] = "Demande mise à jour.";
                header('Location: /demandes');
                exit;
            } else {
                $_SESSION['error'] = "Modification impossible ou non autorisée.";
                header('Location: /demandes');
                exit;
            }

        } else {
            $request = $this->model->getById($id);

            if (!$request || $request['user_id'] != $_SESSION['user_id']) {
                $_SESSION['error'] = "Accès refusé.";
                header('Location: /demandes');
                exit;
            }

            render('edit', [
                'title'   => 'Modifier la demande',
                'request' => $request
            ]);
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit;
        }

        if ($this->model->delete($id, $_SESSION['user_id'])) {
            $_SESSION['success'] = "La demande a été supprimée.";
        } else {
            $_SESSION['error'] = "Suppression impossible ou non autorisée.";
        }

        header('Location: /mesdemandes');
        exit;
    }

    
    public function mesDemandes() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /connexion');
        exit;
    }

    $userId = $_SESSION['user_id'];
    $requests = $this->model->getByUserId($userId);

    render('mesdemandes', [
        'title'    => 'Mes demandes',
        'requests' => $requests
    ]);
}
}