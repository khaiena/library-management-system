<style>

/* ===== BASE ===== */
body{
font-family:"Arial Black", sans-serif;
background:#fdfdfd;
}

/* WRAPPER */
.card-wrapper{
display:flex;
flex-direction:column;
align-items:center;
margin-top:60px;
gap:20px;
}

/* ===== REAL CARD SIZE ===== */
.member-card{
width:85.6mm;
height:54mm;

background:#fef9c3;
border:3px solid #000;
box-shadow:8px 8px 0 #000;

display:flex;
flex-direction:column;
justify-content:space-between;

padding:12px;
}

/* HEADER */
.card-header{
background:#2dd4bf;
border:2px solid #000;
padding:6px;
font-weight:900;
text-align:center;
font-size:12px;
}

/* BODY */
.card-body{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:8px;
}

/* TEXT AREA */
.card-info{
font-size:11px;
line-height:1.4;
}

/* QR */
.card-body img{
width:70px;
border:2px solid #000;
padding:3px;
background:#fff;
}

/* BUTTON */
.print-btn{
border:2px solid #000;
background:#bfdbfe;
padding:10px 16px;
font-weight:bold;
cursor:pointer;
box-shadow:4px 4px 0 #000;
}

/* ===== PRINT FIX ===== */
@media print {

*{
-webkit-print-color-adjust: exact;
print-color-adjust: exact;
}

.print-btn{
display:none;
}

body{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

.member-card{
box-shadow:none;
}

}

.member-since{
margin-top:6px;
font-size:10px;
font-weight:bold;
border-top:2px solid #000;
padding-top:4px;
}

.card-photo{
width:50px;
height:50px;
object-fit:cover;   
border:2px solid #000;
}
</style>


<div class="card-wrapper">

  <div class="member-card">

    <div class="card-header">
      LIBRARY CARD
    </div>

    <div class="card-body">
<div class="card-info">

  <img src="uploads/<?= $user['profile_pic'] ?>" class="card-photo">

  <p>ID: <?= str_pad($user['id'], 4, '0', STR_PAD_LEFT) ?></p>
  <p><?= $user['email'] ?></p>

  <p class="member-since">
    Since: 
    <?= isset($user['created_at']) 
        ? date('d-m-Y', strtotime($user['created_at'])) 
        : '-' ?>
  </p>

</div>

      <img src="<?= $qr ?>" alt="QR Code">

    </div>

  </div>

  <button onclick="window.print()" class="print-btn">
    Print Card
  </button>

</div>