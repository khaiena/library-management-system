<?php

require_once __DIR__ . '/../models/Borrowing.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../../core/Database.php';

class BorrowController {

    private $borrowModel;
    private $bookModel;

    public function __construct() {

        $db = new Database();
        $conn = $db->connect();

        $this->borrowModel = new Borrowing($conn);
        $this->bookModel = new Book($conn);
    }

    public function borrow(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $user_id = $_SESSION['user_id'];
            $book_id = $_POST['book_id'];

            $pickup_date = $_POST['pickup_date'];
$pickup_method = $_POST['pickup_method'];

$due_date = date('Y-m-d', strtotime($pickup_date . ' +7 days'));

            if($this->borrowModel->isBorrowed($book_id)){
                header("Location: index.php?page=books&error=book_taken");
                exit;
            }

            // simpan transaksi borrow
            $this->borrowModel->borrowBook(
    $user_id,
    $book_id,
    $due_date,
    $pickup_date,
    $pickup_method
);

            // ubah status buku jadi borrowed
            $this->bookModel->setBorrowed($book_id);

            header("Location: index.php?page=books");
            exit;
        }
    }

    public function returnBook() {

        $id = $_GET['id'];

        $this->borrowModel->returnBook($id);

        header("Location: index.php?page=borrowings");
    }

    public function index() {

        $borrowings = $this->borrowModel->getAll();

        require __DIR__ . '/../views/borrowings/index.php';
    }

    public function return() {

        $id = $_GET['id'];

        $borrowing = $this->borrowModel->find($id);

        require __DIR__ . '/../views/borrowings/return.php';
    }
public function processReturn(){

$id = $_POST['id'];

$borrowing = $this->borrowModel->find($id);

$today = date('Y-m-d');
$due = $borrowing['due_date'];

$fine = 0;

if($today > $due){

$lateDays = (strtotime($today) - strtotime($due)) / (60*60*24);

$fine = $lateDays * 1000;

}

/* update return */
$this->borrowModel->returnBook($id,$fine);

/* kembalikan buku */
$this->bookModel->setAvailable($borrowing['book_id']);

header("Location: index.php?page=borrowings");
exit;

}
public function payFine(){

    $id = $_POST['id'];

    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE borrowings SET fine = 0 WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();

    echo "success";
}

public function uploadPayment(){

    $id = $_POST['id'];

    $file = $_FILES['proof']['name'];
    $tmp = $_FILES['proof']['tmp_name'];

    $path = "uploads/" . time() . "_" . $file;
    move_uploaded_file($tmp, $path);

    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE borrowings 
            SET payment_proof=?, payment_status='pending' 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$path,$id);
    $stmt->execute();

    echo "success";
}

public function verifyPayment(){

    $id = $_GET['id'];

    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE borrowings 
            SET payment_status='paid', fine=0 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();

    header("Location: index.php?page=borrowings");
    exit;
}

}