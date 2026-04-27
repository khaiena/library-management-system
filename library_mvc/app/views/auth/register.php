<?php require '../app/views/partials/header.php'; ?>

<div class="auth-wrapper">

  <div class="auth-card">

    <h2>✨ Create Account</h2>

    <form method="POST">

      <input type="text" name="name" placeholder="Nama" required>

      <input type="email" name="email" placeholder="Email" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Register</button>

    </form>

    <p class="auth-switch">
      Sudah punya akun?
      <a href="index.php?page=login">Login</a>
    </p>

  </div>

</div>

<?php require '../app/views/partials/footer.php'; ?>