<?php

require_once __DIR__ . '/../models/Borrowing.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/Database.php';

class UserController {

private $borrowModel;
private $userModel;

public function __construct(){

$db = new Database();
$conn = $db->connect();

$this->borrowModel = new Borrowing($conn);
$this->userModel = new User($conn); // ✅ FIX
}

public function card(){

    $id = $_SESSION['user_id'];

    $user = $this->userModel->find($id);

    $qrData = "http://localhost/library_mvc/public/index.php?page=member&id=" . $user['id'];

    $qr = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);

    require __DIR__ . '/../views/users/card.php';
}


public function profile(){

    $id = $_SESSION['user_id'];

    // 🔥 ambil user
    $user = $this->userModel->find($id);

    // 🔥 ambil borrowings (INI YANG TADI HILANG)
    $borrowings = $this->borrowModel->getByUser($id);

    // 🔥 ubah jadi array + hitung fine realtime
    $data = [];

    while($row = $borrowings->fetch_assoc()){

        $today = date('Y-m-d');

        if($today > $row['due_date']){
            $lateDays = (strtotime($today) - strtotime($row['due_date'])) / (60*60*24);
            $row['fine'] = $lateDays * 1000;
        }

        $data[] = $row;
    }

    $borrowings = $data;

    require __DIR__ . '/../views/profile/index.php';
}

public function show(){

    $id = $_GET['id'];

    $user = $this->userModel->find($id);

    require __DIR__ . '/../views/users/show.php';
}

public function uploadPhoto(){

    $id = $_SESSION['user_id'];

    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name']){

        $fileName = time() . '_' . $_FILES['profile_pic']['name'];

            move_uploaded_file(
            $_FILES['profile_pic']['tmp_name'],
            __DIR__ . '/../../public/uploads/' . $fileName
             );

        $this->userModel->updatePhoto($id, $fileName);
    }

    header("Location: index.php?page=profile");
    exit;
}

public function update(){

    $id = $_SESSION['user_id'];

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->connect();

    // 🔥 kalau password diisi
    if(!empty($password)){

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi",$email,$hashed,$id);

    } else {

        $sql = "UPDATE users SET email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",$email,$id);
    }

    $stmt->execute();

    // update session
    $_SESSION['email'] = $email;

    header("Location: index.php?page=profile");
    exit;
}

public function delete (){
    if($_SESSION['role'] != 'admin'){
        die("Access Denied");
    }

    $id = $_GET['id'];

    $this->userModel->delete($id);
    header("Location: index.php?page=users");
    exit;
}

public function index(){

    if($_SESSION['role'] != 'admin'){
        die("Access denied");
    }

    $users = $this->userModel->getAll();

    require __DIR__ . '/../views/users/index.php';
}

}