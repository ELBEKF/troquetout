<?php 




function render($view, $data)
{
    extract($data);
    var_dump($title);

    ob_start();
    require_once 'views/pages/' . $view . '.html.php'; // views/hompage.html.php
    $content = ob_get_clean();
    require_once 'views/base.html.php';
}