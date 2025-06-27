<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/RequestController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $requestController = new RequestController($pdo);
    $requestController->delete((int)$_POST['id']);
} else {
    header('Location: demandes.php');
    exit;
}
