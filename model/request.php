<?php
class Request {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO requests (user_id, titre, description, type_demande, date_besoin)
                                     VALUES (:user_id, :titre, :description, :type_demande, :date_besoin)");
        return $stmt->execute($data);
    }

    public function getAll(): array {
    $stmt = $this->pdo->query("SELECT r.*, u.nom, u.prenom FROM requests r
                               JOIN users u ON r.user_id = u.id
                               ORDER BY r.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function update($id, $data) {
    $sql = "UPDATE requests SET titre = :titre, description = :description, type_demande = :type_demande, date_besoin = :date_besoin WHERE id = :id AND user_id = :user_id";
    $stmt = $this->pdo->prepare($sql);
    $data['id'] = $id;
    return $stmt->execute($data);
}

public function delete($id, $user_id) {
    $sql = "DELETE FROM requests WHERE id = :id AND user_id = :user_id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
}
public function getById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getByUserId($userId) {
    $stmt = $this->pdo->prepare("SELECT * FROM requests WHERE user_id = :user_id ORDER BY date_besoin DESC");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}

