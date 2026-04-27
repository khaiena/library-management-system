<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/navbar.php'; ?>

<div class="form-container">

<h2>Edit Book</h2>

<form method="POST" action="index.php?page=update_book">

<input type="hidden" name="id" value="<?= $book['id'] ?>">

<label>Title</label>
<input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

<label>Author</label>
<input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

<label>Year</label>
<input type="number" name="year" value="<?= $book['year'] ?>" required>

<label>Synopsis</label>
<textarea name="synopsis" rows="4"></textarea>

<label>Category</label>
<select name="category_id">

<?php while($cat = $categories->fetch_assoc()): ?>

<option value="<?= $cat['id'] ?>"
<?= $book['category_id'] == $cat['id'] ? 'selected' : '' ?>>

<?= htmlspecialchars($cat['name']) ?>

</option>

<?php endwhile; ?>

</select>
<label>
<input 
type="checkbox" 
name="availability" 
value="1"
<?= $book['availability'] ? 'checked' : '' ?>
>

Available
</label>
<button type="submit">💾 Save Changes</button>

</form>

<a class="back-link" href="index.php?page=books">
← Back to Library
</a>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>