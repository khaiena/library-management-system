-- =========================================
-- LIBRARY MVC DATABASE
-- =========================================

CREATE DATABASE IF NOT EXISTS library_mvc;
USE library_mvc;

-- =========================================
-- USERS
-- =========================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- contoh admin
INSERT INTO users (email,password,role) VALUES
('admin@library.com','$2y$10$abcdefghijklmnopqrstuv','admin');


-- =========================================
-- CATEGORIES
-- =========================================

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name) VALUES
('Science'),
('Technology'),
('Fiction'),
('History');


-- =========================================
-- BOOKS
-- =========================================

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(200),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
    REFERENCES categories(id)
    ON DELETE SET NULL
);

INSERT INTO books (title,author,category_id) VALUES
('Clean Code','Robert C. Martin',2),
('The Pragmatic Programmer','Andrew Hunt',2),
('Harry Potter','J.K Rowling',3);


-- =========================================
-- BORROWINGS
-- =========================================

CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    book_id INT NOT NULL,

    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (book_id)
    REFERENCES books(id)
    ON DELETE CASCADE
);


-- =========================================
-- FINES
-- =========================================

CREATE TABLE fines (
    id INT AUTO_INCREMENT PRIMARY KEY,

    borrowing_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    paid_status ENUM('paid','unpaid') DEFAULT 'unpaid',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (borrowing_id)
    REFERENCES borrowings(id)
    ON DELETE CASCADE
);