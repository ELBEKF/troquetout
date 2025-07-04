<?php
session_start();


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/MessagesController.php';

$controller = new MessagesController();
$controller->receivedMessages($pdo);
