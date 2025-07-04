<?php
require_once 'config/database.php';
require_once 'controllers/PropositionController.php';

$controller = new PropositionController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $controller->envoyer($pdo);
} else {
    $controller->form($pdo);
}
