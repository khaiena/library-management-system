<?php

class Database {

    private $conn;

    public function connect(){

        $config = require __DIR__ . '/../config/database.php';

        $this->conn = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['dbname'],
            $config['port']
        );

        if($this->conn->connect_error){
            die("Database connection failed");
        }

        return $this->conn;
    }
}