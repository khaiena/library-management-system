<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<h2>Return Book</h2>

<p>
Are you sure you want to return this book?
</p>

<table>

<tr>
<td><b>User ID</b></td>
<td><?= $borrowing['user_id'] ?></td>
</tr>

<tr>
<td><b>Book ID</b></td>
<td><?= $borrowing['book_id'] ?></td>
</tr>

<tr>
<td><b>Borrow Date</b></td>
<td><?= $borrowing['borrow_date'] ?></td>
</tr>

<tr>
<td><b>Due Date</b></td>
<td><?= $borrowing['due_date'] ?></td>
</tr>

</table>

<br>

<form method="POST" action="index.php?page=process_return">

<input type="hidden" name="id" value="<?= $borrowing['id'] ?>">

<button type="submit">
Confirm Return
</button>

</form>

<br>

<a href="index.php?page=borrowings">
<button>Cancel</button>
</a>

<?php require '../app/views/partials/footer.php'; ?>