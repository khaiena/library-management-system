<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<div class="book-detail">

<h2><?= $book['title'] ?></h2>

<p><?= $book['author'] ?> (<?= $book['year'] ?>)</p>

<p class="category">
Category: <?= $book['category_name'] ?? '-' ?>
</p>

<div class="synopsis">

<h3>Synopsis</h3>

<p>
<?= nl2br(htmlspecialchars($book['synopsis'])) ?>
</p>

</div>

</div>

<?php require '../app/views/partials/footer.php'; ?>