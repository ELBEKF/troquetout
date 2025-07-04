<?php
require_once 'config/database.php';
require_once 'controllers/AdminController.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $controller = new AdminController();
    $controller->deleteUser($pdo, intval($_GET['id']));
} else {
    header("Location: /admin.php");
    exit;
}
