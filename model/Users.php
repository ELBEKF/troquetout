<?php
/**
 * Modèle Users — Gestion complète des membres
 * Hérite de la classe Database pour centraliser la connexion PDO
 */
require_once __DIR__ . '/Database.php';

class Users extends Database 
{
    // Propriétés de l'utilisateur (Optionnelles si tu travailles en tableaux associatifs)
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

    /**
     * Constructeur simplifié : Appelle le constructeur de Database
     * pour établir la connexion via $this->pdo
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Vérifie si un email existe déjà (Sécurité Inscription)
     */
    public function emailExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère un utilisateur par son email (Authentification)
     */
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Inscription d'un nouvel utilisateur (CRUD - Create)
     */
    public function addUsers($data)
    {
        $query = '
            INSERT INTO users (nom, prenom, email, password, role, telephone, ville, code_postal, date_inscription)
            VALUES (:nom, :prenom, :email, :password, :role, :telephone, :ville, :code_postal, NOW())
        ';
        $stmt = $this->pdo->prepare($query);

        $stmt->execute([
            ":nom" => $data['nom'],
            ":prenom" => $data['prenom'],
            ":email" => $data['email'],
            ":password" => $data['password'],
            ":role" => $data['role'] ?? 'utilisateur',
            ":telephone" => $data['telephone'] ?? null,
            ":ville" => $data['ville'] ?? null,
            ":code_postal" => $data['code_postal'] ?? null
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     * Récupère les données d'un profil par ID (CRUD - Read)
     */
    public function readProfil($id)
    {
        $query = '
            SELECT id, nom, prenom, email, role, telephone, ville, code_postal, date_inscription
            FROM users
            WHERE id = :id
        ';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Met à jour les informations du profil (CRUD - Update)
     */
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

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Administration : Liste tous les utilisateurs
     */
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY date_inscription DESC");
        return $stmt->fetchAll();
    }

    /**
     * Administration : Met à jour un utilisateur (Admin)
     */
    public function updateUser($id, $nom, $prenom, $email, $telephone, $ville, $code_postal)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET nom = ?, prenom = ?, email = ?, telephone = ?, ville = ?, code_postal = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$nom, $prenom, $email, $telephone, $ville, $code_postal, $id]);
    }

    /**
     * Administration : Supprime un compte (CRUD - Delete)
     */
    public function deleteUserById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}