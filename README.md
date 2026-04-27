#  Library Management System

A web-based library management system built as a final school project to explore system design, user roles, and API integration.

-----

##  Features

-  *User & Admin roles* — separate access and permissions for each role
-  *Book indexing system* — organize and manage library collections
-  *ISBN scanner* — camera-based scanner using public book APIs (works for EU/US books; Indonesian books are not supported due to the lack of a public API)
-  *Manual payment verification* — admin can verify member payments manually

-----

## 🛠️ Tech Stack

|Layer   |Technology           |
|--------|---------------------|
|Backend |PHP                  |
|Database|MySQL                |
|Frontend|JavaScript, HTML, CSS|
|Server  |WAMP / XAMPP         |

-----

## ⚙️ Prerequisites

Before running this project, make sure you have:

- *PHP* x.x.x ← fill in your version
- *MySQL* x.x.x ← fill in your version
- *WAMP* or *XAMPP* installed

-----

##  How to Run

1. *Clone this repository*
   
   bash
   git clone https://github.com/khaiena/library-management-system.git
   
1. *Move the project folder* to your local server directory:
- XAMPP: C:/xampp/htdocs/
- WAMP: C:/wamp64/www/
1. *Import the database*
- Open *phpMyAdmin* (http://localhost/phpmyadmin)
- Create a new database (e.g. library_db)
- Import the provided .sql file from the /database folder
1. *Configure the connection*
- Open the database config file and update your DB name, username, and password
1. *Run the project*
- Open your browser and go to http://localhost/library-management-system

-----

##  Project Structure


library-management-system/
├── database/         # SQL file for database setup
├── assets/           # CSS, JS, images
├── admin/            # Admin panel pages
├── user/             # User panel pages
└── index.php         # Entry point


-----

##  Notes

- The ISBN scanner uses a public book API and currently only supports *international books (EU/US)*. Indonesian books are not supported as there is no available public API for them.
- Manual payment verification is handled by the admin after reviewing proof of payment.

-----

##  About

This project was built as a *final school project* to explore system design, user roles, and API integration. The project is complete and open for improvements or contributions.
