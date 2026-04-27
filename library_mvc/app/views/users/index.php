<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>


<h2>Users</h2>

<table border="1" cellpadding="10">

<tr>
  <th>ID</th>
  <th>Email</th>
  <th>Role</th>
  <th>Action</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>
<tr>

<td><?= $u['id'] ?></td>
<td><?= $u['email'] ?></td>
<td><?= $u['role'] ?></td>

<td>
<a href="index.php?page=delete_user&id=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">
  ❌ Delete
</a>
</td>

</tr>
<?php endwhile; ?>

</table>

<?php require '../app/views/partials/footer.php'; ?>