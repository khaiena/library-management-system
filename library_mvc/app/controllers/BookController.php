<?php

require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../../core/Database.php';

class BookController {

    private $bookModel;
    private $categoryModel;

    public function __construct() {

        $db = new Database();
        $conn = $db->connect();

        $this->bookModel = new Book($conn);
        $this->categoryModel = new Category($conn);
    }

public function index(){

if(isset($_GET['search']) && $_GET['search'] != ''){

$keyword = $_GET['search'];

$books = $this->bookModel->search($keyword);

}else{

$books = $this->bookModel->getAll();

}

/* TOP PICKS */

$topBooks = $this->bookModel->getTopBorrowed();

require __DIR__ . '/../views/books/index.php';

}
 public function create() {

    if($_SESSION['role'] != 'admin'){
        die("Access denied");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = (int) $_POST['year'];
        $category_id = (int) $_POST['category_id'];
        $synopsis = $_POST['synopsis'];

        $this->bookModel->create($title,$author,$year,$category_id,$synopsis);

        header("Location: /library_mvc/public/index.php?page=books");
        exit;
    }

    $categories = $this->categoryModel->getAll();

    require __DIR__ . '/../views/books/create.php';
}

    public function edit() {

        if($_SESSION['role'] != 'admin'){
            die("Access denied");
        }

        $id = $_GET['id'];

        $book = $this->bookModel->find($id);
        $categories = $this->categoryModel->getAll();

        require __DIR__ . '/../views/books/edit.php';
    }

  public function update(){

if($_SESSION['role'] != 'admin'){
die("Access denied");
}

$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];
$year = $_POST['year'];
$category_id = $_POST['category_id'];
$synopsis = $_POST['synopsis'];

$availability = isset($_POST['availability']) ? 1 : 0;

$this->bookModel->update($id,$title,$author,$year,$category_id,$availability,$synopsis);

header("Location: /library_mvc/public/index.php?page=books");
exit;
}

    public function delete() {

        if($_SESSION['role'] != 'admin'){
            die("Access denied");
        }

        $id = $_GET['id'];

        $this->bookModel->delete($id);

        header("Location: /library_mvc/public/index.php?page=books");
        exit;
    }


    public function show(){

$id = $_GET['id'];

$book = $this->bookModel->find($id);

require __DIR__ . '/../views/books/show.php';

}

public function isbnLookup(){

    header('Content-Type: application/json');

    $isbn = preg_replace('/[^0-9]/', '', $_GET['isbn']);

    // ======================
    // 1. OPENLIBRARY
    // ======================
    $url = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data";

    $response = file_get_contents($url);

    if($response !== false){
        $data = json_decode($response, true);

        if(isset($data["ISBN:$isbn"])){

            $book = $data["ISBN:$isbn"];

            $notes = '';

            if(isset($book['notes'])){
                if(is_string($book['notes'])){
                    $notes = $book['notes'];
                } elseif(is_array($book['notes']) && isset($book['notes']['value'])){
                    $notes = $book['notes']['value'];
                }
            }

            echo json_encode([
                "title" => $book['title'] ?? '',
                "author" => $book['authors'][0]['name'] ?? '',
                "year" => $book['publish_date'] ?? '',
                "synopsis" => $notes
            ]);
            return;
        }
    }

    // ======================
    // 2. GOOGLE BOOKS (FALLBACK)
    // ======================
    $googleUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";

    $googleResponse = file_get_contents($googleUrl);

    if($googleResponse !== false){
        $googleData = json_decode($googleResponse, true);

        if(isset($googleData['items'][0]['volumeInfo'])){

            $info = $googleData['items'][0]['volumeInfo'];

            echo json_encode([
                "title" => $info['title'] ?? '',
                "author" => $info['authors'][0] ?? '',
                "year" => isset($info['publishedDate']) 
                            ? substr($info['publishedDate'], 0, 4) 
                            : '',
                "synopsis" => $info['description'] ?? ''
            ]);
            return;
        }
    }

    // ======================
    // 3. TOTAL FAIL
    // ======================
    echo json_encode([
        "error" => "Book not found"
    ]);
}
}