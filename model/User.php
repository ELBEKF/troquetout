<?php

class Users
{
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $role;
    public $telephone;
    public $ville;
    public $code_postal;
    public $date_inscription;
    

    public function __construct(
        $nom = null, $prenom = null, $email = null, $password = null, $role = null,
        $telephone = null, $ville = null, $code_postal = null, $date_inscription = null, $id = null
    )    
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->telephone = $telephone;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->date_inscription = $date_inscription;
        $this->id = $id;
    }

    public function addUsers($pdo)
    {
        $query = '
            INSERT INTO users (nom, prenom, email, password, role, telephone, ville, code_postal, date_inscription)
            VALUES (:nom, :prenom, :email, :password, :role, :telephone, :ville, :code_postal, :date_inscription)
        ';
        $stmt = $pdo->prepare($query);

        $stmt->execute([
            ":nom" => $this->nom,
            ":prenom" => $this->prenom,
            ":email" => $this->email,
            ":password" => $this->password,
            ":role" => $this->role,
            ":telephone" => $this->telephone,
            ":ville" => $this->ville,
            ":code_postal" => $this->code_postal,
            ":date_inscription" => $this->date_inscription
        ]);

        // Retourne l'id du nouvel utilisateur
        return $pdo->lastInsertId();
    }

    public function readProfil($pdo, $id)
{
    $query = '
        SELECT nom, prenom, email, role, telephone, ville, code_postal, date_inscription
        FROM users
        WHERE id = :id
    ';

    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}