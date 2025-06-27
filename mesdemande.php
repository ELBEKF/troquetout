<?php
require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/RequestController.php';

$controller = new RequestController($pdo);
$controller->mesDemandes();
