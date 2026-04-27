<?php

require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Borrowing.php';
require_once __DIR__ . '/../../core/Database.php';

class DashboardController {

    private $bookModel;
    private $borrowModel;

    public function __construct() {

        $db = new Database();
        $conn = $db->connect();

        $this->bookModel = new Book($conn);
        $this->borrowModel = new Borrowing($conn);
    }

    public function index() {

        $totalBooks = $this->bookModel->countBooks();
        $borrowedBooks = $this->borrowModel->countBorrowed();

        $stats = $this->borrowModel->borrowStats();

        require __DIR__ . '/../views/dashboard/index.php';
    }

  
}