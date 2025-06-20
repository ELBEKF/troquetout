<?php
// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=troquetout;charset=utf8";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    // Activation des erreurs PDO (bonnes pratiques)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}
