<!DOCTYPE html>
<html>
<head>

<title>BiblioBerry 🍓</title>
<link rel="icon" href="/library_mvc/public/assets/images/stb.png">

<style>

/* ===== RESET ===== */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:"Arial Black", sans-serif;
}

body{
background:#fdfdfd;
color:#000;
}

/* ===== COLOR SYSTEM ===== */
:root{
--turquoise:#2dd4bf;
--pastel-pink:#fbcfe8;
--pastel-blue:#bfdbfe;
--pastel-yellow:#fef9c3;
--pastel-purple:#e9d5ff;
--black:#000;
--white:#fff;
}

/* ===== LAYOUT ===== */
.container{
width:90%;
margin:auto;
}

/* ===== NAVBAR (STICKY + ROUNDED) ===== */
.navbar{
position:sticky;
top:20px;
z-index:999;

display:flex;
justify-content:space-between;
align-items:center;

margin:20px auto;
width:90%;

padding:16px 24px;

background:var(--turquoise);
border:3px solid var(--black);
border-radius:20px;

box-shadow:6px 6px 0 var(--black);
}

.logo{
font-weight:900;
letter-spacing:2px;
}

.nav-menu{
display:flex;
gap:20px;
}

.nav-menu a{
color:#000;
text-decoration:none;
font-weight:bold;
}

.nav-menu a:hover{
text-decoration:underline;
}

.nav-actions{
display:flex;
gap:10px;
}

/* ===== BUTTON BASE ===== */
button,
.add-btn,
.logout-btn,
.search-btn,
.borrow-btn{
border:2px solid var(--black);
background:var(--pastel-blue);
color:#000;
padding:10px 16px;
font-weight:bold;
cursor:pointer;
box-shadow:4px 4px 0 var(--black);
transition:0.1s;
}

button:hover,
.add-btn:hover,
.logout-btn:hover,
.search-btn:hover,
.borrow-btn:hover{
transform:translate(3px,3px);
box-shadow:1px 1px 0 var(--black);
}

/* VARIANTS */
.delete-btn{
background:var(--pastel-pink);
}

.edit-btn{
background:var(--pastel-purple);
}

.borrow-btn{
background:var(--turquoise);
color:#000;
}

/* ===== TITLE ===== */
h2{
margin-top:30px;
font-weight:900;
}

/* ===== BOOK GRID ===== */
.books-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
gap:20px;
margin-top:30px;
}

/* ===== CARD ===== */
.book-card,
.stat-card,
.chart-card,
.form-container,
.top-card{
background:var(--pastel-yellow);
border:3px solid var(--black);
padding:20px;
box-shadow:6px 6px 0 var(--black);
}

/* RANDOM PASTEL VARIATION (biar rainbow feel) */
.book-card:nth-child(2n){
background:var(--pastel-blue);
}
.book-card:nth-child(3n){
background:var(--pastel-pink);
}
.book-card:nth-child(4n){
background:var(--pastel-purple);
}

/* CARD INTERACTION */
.book-card:hover,
.top-card:hover{
transform:translate(4px,4px);
box-shadow:2px 2px 0 var(--black);
}

/* ===== TEXT ===== */
.book-card h3{
margin-bottom:6px;
}

.book-card p{
font-size:14px;
}

/* ===== ACTIONS ===== */
.book-actions{
margin-top:15px;
display:flex;
gap:10px;
}

/* ===== FORM ===== */
.form-container{
max-width:420px;
margin:80px auto;
background:var(--pastel-blue);
border-radius:20px;
}

input,select,textarea{
width:100%;
padding:10px;
margin:6px 0;
border:2px solid var(--black);
background:var(--white);
color:#000;
}

/* ===== TABLE ===== */
table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:10px;
border:2px solid var(--black);
}

th{
background:var(--turquoise);
}

/* ===== LINKS ===== */
a{
color:#000;
text-decoration:underline;
font-weight:bold;
}

/* ===== DASHBOARD ===== */
.dashboard{
margin-top:30px;
}

.stats-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
margin-bottom:30px;
}

.stat-label{
font-size:14px;
}

.stat-value{
font-size:28px;
font-weight:900;
}

/* ===== SEARCH ===== */
.search-bar{
display:flex;
gap:10px;
margin:25px auto;
width:60%;
max-width:600px;
}

.search-input{
flex:1;
padding:10px;
border:2px solid var(--black);
background:#fff;
}

/* ===== CAROUSEL ===== */
.top-carousel{
display:flex;
gap:20px;
overflow-x:auto;
padding:10px 0;
}

/* ===== BADGE ===== */
.top-badge{
background:var(--turquoise);
color:#000;
padding:4px 8px;
font-weight:bold;
border:2px solid var(--black);
display:inline-block;
margin-bottom:10px;
}

/* ===== MODAL ===== */
.book-modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.5);
justify-content:center;
align-items:center;
}

.book-modal-content{
background:var(--pastel-yellow);
border:3px solid var(--black);
padding:30px;
width:420px;
box-shadow:6px 6px 0 var(--black);
border-radius:20px;
}

.close-modal{
position:absolute;
right:16px;
top:12px;
font-size:22px;
cursor:pointer;
}

/* ===== FOOTER ===== */
.footer{
margin-top:60px;
padding:20px 0;
border-top:3px solid var(--black);
text-align:center;
font-weight:bold;
}

/* ===== WRAPPER ===== */
.card-wrapper{
display:flex;
flex-direction:column;
align-items:center;
margin-top:60px;
gap:20px;
}

/* ===== CARD ===== */
.member-card{
width:340px;
background:#fef9c3;
border:3px solid #000;
box-shadow:8px 8px 0 #000;
transition:.2s;
}

/* HEADER */
.card-header{
background:#2dd4bf;
border-bottom:3px solid #000;
padding:12px;
font-weight:900;
text-align:center;
}

/* BODY */
.card-body{
padding:20px;
text-align:center;
}

/* QR */
.card-body img{
margin-top:15px;
width:120px;
border:2px solid #000;
padding:5px;
background:#fff;
}

/* TEXT */
.card-body p{
margin:6px 0;
}

/* BUTTON */
.print-btn{
border:2px solid #000;
background:#bfdbfe;
padding:10px 16px;
font-weight:bold;
cursor:pointer;
box-shadow:4px 4px 0 #000;
transition:.1s;
}

.print-btn:hover{
transform:translate(3px,3px);
box-shadow:1px 1px 0 #000;
}

/* HOVER */
.member-card:hover{
background:#fbcfe8;
}

/* ================= PRINT FIX TOTAL ================= */
@media print {

/* WAJIB BIAR WARNA KELUAR */
*{
-webkit-print-color-adjust: exact;
print-color-adjust: exact;
}

/* HIDE BUTTON */
.print-btn{
display:none;
}

/* RESET BODY */
body{
background:#fff;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
margin:0;
}

/* CARD KHUSUS PRINT */
.member-card{
width:320px;
margin:0 auto;
background:#fef9c3 !important;
border:3px solid #000 !important;
box-shadow:none !important;
page-break-inside:avoid;
}

/* HEADER PRINT */
.card-header{
background:#2dd4bf !important;
}

/* QR FIX */
.card-body img{
border:2px solid #000;
background:#fff;
}

/* OPTIONAL: biar gak kepotong */
@page{
margin:0;
}

}

/* HEADER FLEX */
.dashboard-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

/* ACTION AREA */
.dashboard-actions{
display:flex;
gap:10px;
}

/* TITLE FIX */
.dashboard-title{
margin:0;
font-weight:900;
}

/* WRAPPER */
.profile-wrapper{
display:grid;
grid-template-columns:300px 1fr;
gap:30px;
margin:40px auto;
width:90%;
align-items:flex-start;
}

/* PROFILE CARD */
.profile-card{
background:#fef9c3;
border:3px solid #000;
box-shadow:6px 6px 0 #000;
padding:20px;
height:fit-content;
}

.profile-card h2{
margin-bottom:15px;
}

/* BUTTON */
.card-btn{
display:inline-block;
margin-top:15px;
padding:10px 14px;
background:#2dd4bf;
border:2px solid #000;
color:#000;
font-weight:bold;
text-decoration:none;
box-shadow:4px 4px 0 #000;
transition:.1s;
}

.card-btn:hover{
transform:translate(2px,2px);
box-shadow:1px 1px 0 #000;
}

/* BORROW CARD */
.borrow-card{
background:#fff;
border:3px solid #000;
box-shadow:6px 6px 0 #000;
padding:20px;
}

/* TABLE */
.profile-table{
width:100%;
border-collapse:collapse;
margin-top:15px;
}

.profile-table th,
.profile-table td{
border:2px solid #000;
padding:10px;
text-align:left;
}

.profile-table th{
background:#2dd4bf;
}

/* FINE BADGE */
.fine-badge{
background:#ff4d4d;
color:#fff;
padding:4px 8px;
border:2px solid #000;
font-weight:bold;
}

/* WRAPPER */
.auth-wrapper{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
background:#fdfdfd;
}

/* CARD */
.auth-card{
width:360px;
background:#fef9c3;
border:3px solid #000;
box-shadow:8px 8px 0 #000;
padding:30px;
text-align:center;
}

/* TITLE */
.auth-card h2{
margin-bottom:20px;
font-weight:900;
}

/* INPUT */
.auth-card input{
width:100%;
padding:12px;
margin:8px 0;
border:2px solid #000;
background:#fff;
font-weight:bold;
}

/* BUTTON */
.auth-card button{
width:100%;
margin-top:10px;
padding:12px;
border:2px solid #000;
background:#2dd4bf;
font-weight:bold;
cursor:pointer;
box-shadow:4px 4px 0 #000;
transition:.1s;
}

.auth-card button:hover{
transform:translate(2px,2px);
box-shadow:1px 1px 0 #000;
}

/* SWITCH */
.auth-switch{
margin-top:15px;
font-size:14px;
}

/* LINK */
.auth-switch a{
font-weight:bold;
}
.profile-card img{
width:80px;
height:80px;
object-fit:cover;
border:2px solid #000;
}
#scanner video{
width:100%;
height:100%;
object-fit:cover;
}

#scanner{
width:300px;
height:200px;
overflow:hidden;
border:2px solid #000;
}
.scan-btn{
border:2px solid #000;
background:#fda4af;
padding:6px 10px;
font-weight:bold;
cursor:pointer;
box-shadow:3px 3px 0 #000;
margin-bottom:10px;
}

settings-card{
  margin-top:30px;
 
}

</style>
</head>

<body>

<div class="container">