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

// Récupérer tous les utilisateurs
// Récupérer tous les utilisateurs
public function getAllUsers($pdo)
{
    $stmt = $pdo->query("SELECT * FROM users ORDER BY date_inscription DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Supprimer un utilisateur par son ID
public function deleteUserById($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

public function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateUser($pdo, $id, $nom, $prenom, $email, $telephone, $ville, $code_postal) {
    $stmt = $pdo->prepare("
        UPDATE users 
        SET nom = ?, prenom = ?, email = ?, telephone = ?, ville = ?, code_postal = ? 
        WHERE id = ?
    ");
    return $stmt->execute([$nom, $prenom, $email, $telephone, $ville, $code_postal, $id]);
}

public function updateProfil($pdo, $id, $data)
{
    $query = '
        UPDATE users SET 
            nom = :nom,
            prenom = :prenom,
            email = :email,
            telephone = :telephone,
            ville = :ville,
            code_postal = :code_postal
            ' . (!empty($data['password']) ? ', password = :password' : '') . '
        WHERE id = :id
    ';

    $stmt = $pdo->prepare($query);

    $params = [
        ':nom' => $data['nom'],
        ':prenom' => $data['prenom'],
        ':email' => $data['email'],
        ':telephone' => $data['telephone'],
        ':ville' => $data['ville'],
        ':code_postal' => $data['code_postal'],
        ':id' => $id
    ];

    if (!empty($data['password'])) {
        $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    return $stmt->execute($params);
}

}