<?php

class Router {

    public function route(){

        $page = $_GET['page'] ?? 'dashboard';

        switch($page){

            case 'login':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->login();
                break;

            case 'register':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->register();
                break;

            case 'logout':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->logout();
                break;

            case 'books':
                require_once __DIR__ . '/../app/controllers/BookController.php';
                $controller = new BookController();
                $controller->index();
                break;

            case 'create_book':
                require_once __DIR__ . '/../app/controllers/BookController.php';
                $controller = new BookController();
                $controller->create();
                break;

           case 'edit_book':
    require '../app/controllers/BookController.php';
    (new BookController())->edit();
    break;

case 'update_book':
    require '../app/controllers/BookController.php';
    (new BookController())->update();
    break;

            case 'delete_book':
                require_once __DIR__ . '/../app/controllers/BookController.php';
                $controller = new BookController();
                $controller->delete();
                break;

            case 'borrowings':
                require_once __DIR__ . '/../app/controllers/BorrowController.php';
                $controller = new BorrowController();
                $controller->index();
                break;

            case 'return':
                require_once __DIR__ . '/../app/controllers/BorrowController.php';
                $controller = new BorrowController();
                $controller->return();
                break;

            case 'dashboard':
            default:
                require_once __DIR__ . '/../app/controllers/DashboardController.php';
                $controller = new DashboardController();
                $controller->index();
                break;
            case 'borrow_book':
            require_once '../app/controllers/BorrowController.php';
            $controller = new BorrowController();
            $controller->borrow();
            break;

                    
            case 'process_return':
            require '../app/controllers/BorrowController.php';
            (new BorrowController())->processReturn();
            break;

            case 'profile':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->profile();
    break;

case 'book':
    require_once __DIR__ . '/../app/controllers/BookController.php';
    (new BookController())->show();
    break;

case 'card':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->card();
    break;

    case 'upload_photo':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->uploadPhoto();
    break;
    case 'isbn_lookup':
    require_once __DIR__ . '/../app/controllers/BookController.php';
    (new BookController())->isbnLookup();
    break;

    case 'pay_fine':
    require_once __DIR__ . '/../app/controllers/BorrowController.php';
    $controller = new BorrowController();
    $controller->payFine();
    break;
    case 'update_user':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->update();
    break;
    case 'delete_user':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->delete();
    break;
    case 'users':
    require_once __DIR__ . '/../app/controllers/UserController.php';
    (new UserController())->index();
    break;
    case 'upload_payment':
    require_once __DIR__ . '/../app/controllers/BorrowController.php';
    (new BorrowController())->uploadPayment();
    break;
    case 'verify_payment':
    require_once __DIR__ . '/../app/controllers/BorrowController.php';
    (new BorrowController())->verifyPayment();
    break;


  
        }
    }

 
}