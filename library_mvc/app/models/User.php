<?php

class User {

    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {

        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($email, $password, $role) {

        $sql = "INSERT INTO {$this->table} (email, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $email, $password, $role);

        return $stmt->execute();
    }

    public function getAll() {

        $sql = "SELECT id, email, role FROM {$this->table}";
        return $this->conn->query($sql);
    }

    public function find($id){

    $id = (int)$id; // biar aman

    $result = $this->conn->query("
        SELECT * FROM users WHERE id = $id
    ");

    return $result->fetch_assoc();
}

public function updatePhoto($id, $fileName){

    $stmt = $this->conn->prepare("
        UPDATE users SET profile_pic=? WHERE id=?
    ");

    $stmt->bind_param("si", $fileName, $id);

    return $stmt->execute();
}

public function delete($id){

    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i",$id);

    return $stmt->execute();
}

}