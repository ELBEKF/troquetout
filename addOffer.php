<?php
session_start();

require_once 'config/database.php';
require_once 'config/render.php';
require_once 'controllers/OffersController.php';

$addOfferController = new OffersController();
$addOfferController->handleAddOffer($pdo);
