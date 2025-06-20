<?php 
require_once dirname(__DIR__) . '/config/render.php';



Class HomeController {

    public function index(){

    render('connexion', [

    "title"=>"Connexion"
]);
    }
}