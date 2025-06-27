<?php
require_once 'config/database.php';
require_once 'controllers/OffersController.php';

$controller = new OffersController();

// Récupération de l'ID depuis l'URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$controller->offerDetail($pdo, $id);
