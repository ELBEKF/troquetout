<?php

require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/RequestController.php';

if (!isset($_GET['id'])) {
    die('ID manquant');
}

$requestController = new RequestController($pdo);
$requestController->update((int)$_GET['id']);
