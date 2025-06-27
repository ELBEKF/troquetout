<?php
require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/OffersController.php';

$controller = new OffersController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->updateoffer($pdo);
} else {
    $controller->modifoffer($pdo, $_GET['id'] ?? null);
}
