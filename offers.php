
<?php

require_once 'config/database.php';
require_once 'controllers/OffersController.php';

$controller = new OffersController(); 
$controller->index($pdo); 
