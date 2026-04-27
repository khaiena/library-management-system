<?php

class Borrowing {

    private $conn;
    private $table = "borrowings";

    public function __construct($db){
        $this->conn = $db;
    }

    /* =========================
       GET ALL BORROWINGS
    ========================= */

 public function getAll(){

    $sql = "SELECT borrowings.*, 
            users.email AS user_email,
            books.title AS book_title,

            CASE 
                WHEN borrowings.return_date IS NULL 
                     AND CURDATE() > borrowings.due_date
                THEN DATEDIFF(CURDATE(), borrowings.due_date) * 1000
                ELSE COALESCE(borrowings.fine, 0)
            END AS fine

            FROM borrowings

            LEFT JOIN users ON borrowings.user_id = users.id
            LEFT JOIN books ON borrowings.book_id = books.id

            ORDER BY borrow_date DESC";

    return $this->conn->query($sql);
}

    /* =========================
       CHECK IF BOOK BORROWED
    ========================= */

    public function isBorrowed($book_id){

        $sql = "SELECT id 
                FROM {$this->table}
                WHERE book_id=? 
                AND return_date IS NULL";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$book_id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;

    }


    /* =========================
       BORROW BOOK
    ========================= */

   public function borrowBook($user_id,$book_id,$due_date,$pickup_date,$pickup_method){

    $sql = "INSERT INTO borrowings 
            (user_id, book_id, borrow_date, due_date, pickup_date, pickup_method)
            VALUES (?, ?, NOW(), ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("iisss",$user_id,$book_id,$due_date,$pickup_date,$pickup_method);

    return $stmt->execute();
}


    /* =========================
       RETURN BOOK
    ========================= */

    public function returnBook($id,$fine=0){

        $sql = "UPDATE {$this->table}
                SET return_date = NOW(),
                fine = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii",$fine,$id);

        return $stmt->execute();

    }


    /* =========================
       COUNT BORROWED BOOKS
    ========================= */

    public function countBorrowed(){

        $sql = "SELECT COUNT(*) AS total
                FROM {$this->table}
                WHERE return_date IS NULL";

        $result = $this->conn->query($sql);

        return $result->fetch_assoc()['total'];

    }


    /* =========================
       FIND SINGLE BORROW
    ========================= */

    public function find($id){

        $sql = "SELECT * 
                FROM {$this->table}
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();

    }


    /* =========================
       DASHBOARD STATISTICS
    ========================= */

    public function borrowStats(){

        $sql = "SELECT 
                MONTH(borrow_date) AS month,
                COUNT(*) AS total
                FROM {$this->table}
                GROUP BY MONTH(borrow_date)
                ORDER BY month";

        $result = $this->conn->query($sql);

        $data = [];

        while($row = $result->fetch_assoc()){

            $data[$row['month']] = $row['total'];

        }

        return $data;

    }


    /* =========================
       USER BORROW HISTORY
    ========================= */

    public function getByUser($user_id){

        $sql = "SELECT borrowings.*,
                books.title AS book_title
                FROM borrowings
                LEFT JOIN books ON borrowings.book_id = books.id
                WHERE user_id=?
                ORDER BY borrow_date DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$user_id);

        $stmt->execute();

        return $stmt->get_result();

    }

}