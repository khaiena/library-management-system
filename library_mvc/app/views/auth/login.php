<?php require '../app/views/partials/header.php'; ?>

<div class="auth-wrapper">

  <div class="auth-card">

    <h2> Welcome Back</h2>

    <form method="POST">

      <input type="email" name="email" placeholder="Email" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Login</button>

    </form>

    <p class="auth-switch">
      Belum punya akun?
      <a href="index.php?page=register">Register</a>
    </p>

  </div>

</div>

<?php require '../app/views/partials/footer.php'; ?>