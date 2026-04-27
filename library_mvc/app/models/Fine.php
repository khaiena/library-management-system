<?php

class Fine {

    private $conn;
    private $table = "fines";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createFine($borrowing_id, $amount) {

        $sql = "INSERT INTO {$this->table} (borrowing_id, amount)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("id", $borrowing_id, $amount);

        return $stmt->execute();
    }

}