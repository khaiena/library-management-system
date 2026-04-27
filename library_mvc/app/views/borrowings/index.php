<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<h2>📚 Borrowings</h2>

<table border="1" cellpadding="10">

<tr>
<th>User</th>
<th>Book</th>
<th>Borrow Date</th>
<th>Due Date</th>
<th>Return Date</th>
<th>Fine</th>
<th>Payment</th>
<th>Action</th>
</tr>

<?php while($b = $borrowings->fetch_assoc()): ?>

<tr>

<td><?= $b['user_id'] ?></td>

<td><?= $b['book_id'] ?></td>

<td><?= $b['borrow_date'] ?></td>

<td><?= $b['due_date'] ?></td>

<td>
<?= $b['return_date'] ? $b['return_date'] : '-' ?>
</td>

<!-- 💸 FINE -->
<td>
<?php if(($b['fine'] ?? 0) > 0): ?>
  <span style="color:#ef4444;">Rp <?= number_format($b['fine']) ?></span>
<?php else: ?>
  -
<?php endif; ?>
</td>

<!-- 💳 PAYMENT STATUS -->
<td>

<?php if(($b['payment_status'] ?? '') == 'pending'): ?>

  <span style="color:orange; font-weight:bold;">⏳ Pending</span>

  <br><br>

  <?php if(!empty($b['payment_proof'])): ?>
    <img src="<?= $b['payment_proof'] ?>" width="70">
  <?php endif; ?>

<?php elseif(($b['payment_status'] ?? '') == 'paid'): ?>

  <span style="color:#22c55e; font-weight:bold;">✅ Paid</span>

<?php else: ?>

  <span style="color:#9ca3af;">-</span>

<?php endif; ?>

</td>

<!-- ⚙️ ACTION -->
<td>

<?php if(!$b['return_date']): ?>

  <a href="index.php?page=return&id=<?= $b['id'] ?>" 
     style="color:#2dd4bf;">
    Return
  </a>

<?php else: ?>

  <span style="color:#9ca3af;">Returned</span>

<?php endif; ?>


<!-- 🔥 VERIFY BUTTON -->
<?php if(($b['payment_status'] ?? '') == 'pending'): ?>

  <br><br>

  <a href="index.php?page=verify_payment&id=<?= $b['id'] ?>"
     onclick="return confirm('Verify payment?')"
     style="color:#22c55e; font-weight:bold;">
     ✅ Verify
  </a>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

<?php require '../app/views/partials/footer.php'; ?>