<?php

class Category {

    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {

        $sql = "SELECT * FROM {$this->table}";
        return $this->conn->query($sql);
    }

}