<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/Database.php';

class AuthController {

    private $userModel;

    public function __construct() {
        $db = new Database();
        $conn = $db->connect();

        $this->userModel = new User($conn);
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {

                session_start();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

               if($user['role'] == 'admin'){
                header("Location: /library_mvc/public/index.php?page=dashboard");
                } else {
                header("Location: /library_mvc/public/index.php?page=books");
                }
                exit;

            } else {
                echo "<script>alert('Login gagal');</script>";
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = "user";

            // cek email sudah dipakai
            if ($this->userModel->findByEmail($email)) {
                echo "<script>alert('Email sudah dipakai');</script>";
                return;
            }

            $this->userModel->create($email, $password, $role);

            header("Location: /library_mvc/public/index.php?page=login");
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout() {

        session_start();
        session_destroy();

        header("Location: /library_mvc/public/index.php?page=login");
    }
}