<?php

require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/RequestController.php';

$requestController = new RequestController($pdo);
$requestController->create();
