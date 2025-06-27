<?php
require_once 'config/database.php';
require_once 'controllers/OffersController.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $controller = new OffersController();
    $controller->delete($pdo, intval($_GET['id']));
} else {
    header("Location: /offers.php");
    exit;
}
