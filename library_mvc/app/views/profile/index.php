<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<div class="profile-wrapper">

  <!-- LEFT: USER INFO -->
  <div class="profile-card">

    <h2>👤 My Profile</h2>
    <p><strong>Photo:</strong></p>

    <img src="uploads/<?= $user['profile_pic'] ?>" width="80">

    <p><strong>Email:</strong><br><?= $_SESSION['email'] ?></p>
    <p><strong>Role:</strong><br><?= $_SESSION['role'] ?></p>

    <a href="index.php?page=card" class="card-btn">
      🎫 My Card
    </a>

    <form method="POST" action="index.php?page=upload_photo" enctype="multipart/form-data">
      <input type="file" name="profile_pic" id="fileInput" hidden>

      <button type="button" onclick="document.getElementById('fileInput').click()" class="upload-btn">
        Ganti Profil
      </button>

      <button type="submit" class="upload-submit">
        Upload
      </button>
    </form>

  </div>

  <!-- RIGHT SIDE -->
  <div style="flex:1;">

    <!-- BORROW TABLE -->
    <div class="borrow-card">

      <h3>📚 Borrowed Books</h3>

      <table class="profile-table">

        <tr>
          <th>Book</th>
          <th>Borrow</th>
          <th>Due</th>
          <th>Fine</th>
        </tr>

        <?php foreach($borrowings as $b): ?>
        <tr>

          <td><?= $b['book_title'] ?? $b['book_id'] ?></td>
          <td><?= $b['borrow_date'] ?></td>
          <td><?= $b['due_date'] ?></td>

          <td>

          <?php if(($b['fine'] ?? 0) > 0 && ($b['payment_status'] ?? '') != 'pending'): ?>

            <span class="fine-badge">
              Rp <?= number_format($b['fine']) ?>
            </span>

            <button type="button" onclick="openQR(<?= $b['id'] ?>)" style="margin-top:5px;">
              💸 Pay
            </button>

          <?php elseif(($b['payment_status'] ?? '') == 'pending'): ?>

            <span style="color:orange; font-weight:bold;">⏳ Pending</span>

          <?php else: ?>
            -
          <?php endif; ?>

          </td>

        </tr>
        <?php endforeach; ?>

      </table>

    </div>

    <!-- SETTINGS -->
    <div class="settings-card" style="margin-top:30px;">

      <button onclick="toggleSettings()" class="settings-btn">
        ⚙️ Account Settings
      </button>

      <div id="settingsBox" style="display:none; margin-top:10px;">

        <form method="POST" action="index.php?page=update_user">

          <label>New Email</label>
          <input type="email" name="email" placeholder="Enter new email">

          <label>New Password</label>
          <input type="password" name="password" placeholder="Leave blank if no change">

          <button type="submit">Update</button>

        </form>

      </div>

    </div>

  </div>

</div>

<!-- 🔥 QR + UPLOAD MODAL -->
<div id="qrModal" style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
justify-content:center;
align-items:center;
">

  <div style="
  background:#fff;
  border:3px solid #000;
  padding:20px;
  text-align:center;
  box-shadow:6px 6px 0 #000;
  ">

    <form id="paymentForm" enctype="multipart/form-data">

      <h3>Scan to Pay</h3>

      <img src="uploads/qr.jpeg" width="200" />

      <p style="font-size:12px; margin-top:10px;">
        Upload bukti pembayaran 
      </p>

      <input type="file" name="proof" required>

      <br><br>

      <button type="button" onclick="submitPayment()" style="margin-right:10px;">
        📤 Upload Bukti
      </button>

      <button type="button" onclick="closeQR()">
         Batal
      </button>

    </form>

  </div>

</div>

<script>

let currentId = null;

function openQR(id){
    currentId = id;
    document.getElementById("qrModal").style.display = "flex";
}

function closeQR(){
    document.getElementById("qrModal").style.display = "none";
}

function submitPayment(){

    let form = document.getElementById("paymentForm");
    let data = new FormData(form);

    data.append("id", currentId);

    fetch("index.php?page=upload_payment", {
        method: "POST",
        body: data
    })
    .then(() => {
        alert("Menunggu verifikasi admin ");
        location.reload();
    });

}

function toggleSettings(){
    let box = document.getElementById("settingsBox");

    if(box.style.display === "none"){
        box.style.display = "block";
    } else {
        box.style.display = "none";
    }
}

</script>

<?php require '../app/views/partials/footer.php'; ?>