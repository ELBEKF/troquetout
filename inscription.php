<?php
session_start();

require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/UsersController.php';

$controller = new UsersController();
$controller->register($pdo);
