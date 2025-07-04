<?php
session_start();
require_once 'config/database.php';   // si tu en as besoin
require_once 'config/render.php';

render('contact', [
    'title' => 'Contactez-nous'
]);
