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

    private $pdo;

    public function __construct(
        $nom = null, $prenom = null, $email = null, $password = null, $role = null,
        $telephone = null, $ville = null, $code_postal = null, $date_inscription = null, $id = null
    ) {
        // Initialisation des propriétés
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

        // Connexion BDD
        $dsn = "mysql:host=localhost;dbname=troquetout;charset=utf8";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
            exit;
        }
    }

    public function addUsers()
    {
        $query = '
            INSERT INTO users (nom, prenom, email, password, role, telephone, ville, code_postal, date_inscription)
            VALUES (:nom, :prenom, :email, :password, :role, :telephone, :ville, :code_postal, :date_inscription)
        ';
        $stmt = $this->pdo->prepare($query);

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

        return $this->pdo->lastInsertId();
    }

    public function readProfil($id)
    {
        $query = '
            SELECT nom, prenom, email, role, telephone, ville, code_postal, date_inscription
            FROM users
            WHERE id = :id
        ';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY date_inscription DESC");
        return $stmt->fetchAll();
    }

    public function deleteUserById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateUser($id, $nom, $prenom, $email, $telephone, $ville, $code_postal)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET nom = ?, prenom = ?, email = ?, telephone = ?, ville = ?, code_postal = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$nom, $prenom, $email, $telephone, $ville, $code_postal, $id]);
    }

    public function updateProfil($id, $data)
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

        $stmt = $this->pdo->prepare($query);

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
    public function emailExists($email)
{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetchColumn() > 0;
}

}
