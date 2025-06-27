<?php

require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/RequestController.php';



$requestController = new RequestController($pdo);

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
