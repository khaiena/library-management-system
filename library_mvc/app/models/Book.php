<?php

class Book {

    private $conn;
    private $table = "books";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {

        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories 
                ON books.category_id = categories.id";

        return $this->conn->query($sql);
    }

  public function create($title,$author,$year,$category_id,$synopsis){

    $availability = 1;

    $sql = "INSERT INTO books (title,author,year,category_id,synopsis,availability)
            VALUES (?,?,?,?,?,?)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("ssissi",$title,$author,$year,$category_id,$synopsis,$availability);

    if(!$stmt->execute()){
        die("ERROR: " . $stmt->error);
    }

    return true;
}

    public function delete($id) {

        $sql = "DELETE FROM {$this->table} WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }

    public function countBooks() {

        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->conn->query($sql);

        return $result->fetch_assoc()['total'];
    }
public function find($id){

    $sql = "SELECT books.*, categories.name AS category_name
            FROM books
            LEFT JOIN categories 
            ON books.category_id = categories.id
            WHERE books.id=?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

   public function update($id,$title,$author,$year,$category_id,$availability,$synopsis){

    $sql = "UPDATE {$this->table} 
            SET title=?, author=?, year=?, category_id=?, availability=?, synopsis=? 
            WHERE id=?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssiissi",$title,$author,$year,$category_id,$availability,$synopsis,$id);

    return $stmt->execute();
}
    public function search($keyword){

        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories 
                ON books.category_id = categories.id
                WHERE books.title LIKE ? 
                OR books.author LIKE ?";

        $stmt = $this->conn->prepare($sql);

        $keyword = "%$keyword%";

        $stmt->bind_param("ss",$keyword,$keyword);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getTopBorrowed(){

        $sql = "SELECT books.*, 
        COUNT(borrowings.book_id) AS total_borrow
        FROM books
        LEFT JOIN borrowings 
        ON books.id = borrowings.book_id
        GROUP BY books.id
        ORDER BY total_borrow DESC
        LIMIT 6";

        return $this->conn->query($sql);

        }

    public function setBorrowed($id){

        $sql = "UPDATE {$this->table} SET availability = 0 WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }

    public function setAvailable($id){

        $sql = "UPDATE {$this->table} SET availability = 1 WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }

    public function topBooks(){

        $sql = "SELECT books.*, COUNT(borrowings.book_id) as total_borrow
        FROM books
        LEFT JOIN borrowings
        ON books.id = borrowings.book_id
        GROUP BY books.id
        ORDER BY total_borrow DESC
        LIMIT 5";

        return $this->conn->query($sql);

        }

}