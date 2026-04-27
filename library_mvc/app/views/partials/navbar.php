<nav class="navbar">

<div class="logo">

<h1>
𝙱𝚒𝚋𝚕𝚒𝚘𝙱𝚎𝚛𝚛𝚢
</h1>

</div>

<div class="nav-menu">

<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>

<a href="index.php?page=dashboard">Dashboard</a>

<?php endif; ?>

<a href="index.php?page=books">Books</a>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>

    <?php if($_SESSION['role'] == 'admin'): ?>
  <a href="index.php?page=users">Users</a>
<?php endif; ?>

<a href="index.php?page=borrowings">Borrowings</a>

<?php endif; ?>

<a href="index.php?page=profile">Profile</a>

</div>

<div class="nav-actions">

<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>

<a href="index.php?page=create_book" class="add-btn">
+ Add New Book
</a>

<?php endif; ?>

<a href="index.php?page=logout">
<button class="logout-btn">Logout</button>
</a>

</div>

</nav>

<div class="user-info">

<?php
$email = $_SESSION['email'] ?? '';

if ($email) {
$name = explode('@', $email)[0];
$role = $_SESSION['role'] ?? '';
?>

<span class="user-name"><?= $name ?></span>
<span class="user-role"><?= $role ?></span>

<?php } ?>

</div>