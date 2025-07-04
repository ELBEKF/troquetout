<?php
require_once 'config/database.php';
require_once 'controllers/UsersController.php';

$controller = new UsersController();
$controller->profil($pdo);
