<?php

// session_start();
require_once dirname(__DIR__) . '/model/request.php';

class RequestController {
    private $model;

    public function __construct() {
        $this->model = new Request();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['user_id'])) {
                echo "Erreur : vous devez être connecté pour créer une demande.";
                exit;
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'type_demande' => $_POST['type_demande'],
                'date_besoin' => $_POST['date_besoin']
            ];

            $this->model->create($data);
            header('Location: /demandes');
            exit;
        }

        render('create', ['title' => 'Créer une demande']);
    }

    public function index() {
        $requests = $this->model->getAll();
        render('demande', [
            'title' => 'Liste des demandes',
            'requests' => $requests
        ]);
    }

    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            echo "Erreur : vous devez être connecté pour modifier une demande.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'type_demande' => $_POST['type_demande'],
                'date_besoin' => $_POST['date_besoin'],
                'user_id' => $_SESSION['user_id']
            ];

            $success = $this->model->update($id, $data);

            if ($success) {
                header('Location: /demandes');
                exit;
            } else {
                echo "Erreur : modification impossible ou non autorisée.";
            }

        } else {
            $request = $this->model->getById($id);

            if (!$request || $request['user_id'] != $_SESSION['user_id']) {
                echo "Erreur : accès refusé.";
                exit;
            }

            render('edit', [
                'title' => 'Modifier la demande',
                'request' => $request
            ]);
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            echo "Erreur : vous devez être connecté pour supprimer une demande.";
            exit;
        }

        $success = $this->model->delete($id, $_SESSION['user_id']);

        if ($success) {
            header('Location: /mesdemandes');
            exit;
        } else {
            echo "Erreur : suppression impossible ou non autorisée.";
        }
    }

    public function mesDemandes() {
    if (!isset($_SESSION['user_id'])) {
        echo "Erreur : vous devez être connecté pour voir vos demandes.";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $requests = $this->model->getByUserId($userId);

    render('mesdemandes', [
        'title' => 'Mes demandes',
        'requests' => $requests
    ]);
}

}
