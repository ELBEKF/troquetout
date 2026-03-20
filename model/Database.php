<?php
// model/Database.php

abstract class Database {
    protected $pdo;

    public function __construct() {

        $isLocal = (isset($_SERVER['HTTP_HOST']) && (
            str_contains($_SERVER['HTTP_HOST'], 'localhost') ||
            str_contains($_SERVER['HTTP_HOST'], '127.0.0.1')
        ));

        if ($isLocal) {

            $host     = 'localhost';
            $dbname   = 'troquetout';
            $username = 'root';
            $password = '';
        } else {
            $host     = 'sql308.infinityfree.com';
            $dbname   = 'if0_41390980_troquet';
            $username = 'if0_41390980';
            $password = 'OqoZOzxZw'; 
        }

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}