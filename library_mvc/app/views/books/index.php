<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<h2>All Books</h2>

<form method="GET" class="search-bar">
<input type="hidden" name="page" value="books">

<input 
type="text" 
name="search" 
placeholder="Search by title or author..."
class="search-input"
>

<button type="submit" class="search-btn">
Search
</button>
</form>


<h2>🔥 Top Picks</h2>

<p class="section-subtitle">
Most borrowed books by readers
</p>


<div class="top-wrapper">

<button class="carousel-btn left" onclick="scrollTopBooks(-1)">❮</button>

<div class="top-carousel" id="topCarousel">

<?php while($top = $topBooks->fetch_assoc()): ?>

<div class="top-card">
<span class="top-badge">Popular</span>

<h3><?= $top['title'] ?></h3>
<p><?= $top['author'] ?></p>

<p class="borrow-count">
<?= $top['total_borrow'] ?> borrows
</p>
</div>

<?php endwhile; ?>

</div>

<button class="carousel-btn right" onclick="scrollTopBooks(1)">❯</button>

</div>


<div class="section-divider"></div>


<div class="books-grid">

<?php while($book = $books->fetch_assoc()): ?>

<div 
class="book-card"
data-title="<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>"
data-author="<?= htmlspecialchars($book['author'], ENT_QUOTES) ?>"
data-synopsis="<?= htmlspecialchars($book['synopsis'], ENT_QUOTES) ?>"
onclick="openBook(this)">

<h3><?= $book['title'] ?></h3>

<p><?= $book['author'] ?> (<?= $book['year'] ?? '' ?>)</p>

<p>
📚 Category: <?= $book['category_name'] ?? 'General' ?>
</p>

<?php if($book['availability']): ?>
<p style="color:#22c55e;">Available</p>
<?php else: ?>
<p style="color:#ef4444;">Borrowed</p>
<?php endif; ?>


<?php if($_SESSION['role'] == 'user' && $book['availability']): ?>

<button 
class="borrow-btn"
onclick="event.stopPropagation(); openBorrowModal(<?= $book['id'] ?>)">
Borrow Book
</button>

<?php endif; ?>


<div class="book-actions">

<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>

<a href="index.php?page=edit_book&id=<?= $book['id'] ?>" onclick="event.stopPropagation()">
<button class="edit-btn">Edit</button>
</a>

<a href="index.php?page=delete_book&id=<?= $book['id'] ?>" onclick="event.stopPropagation()">
<button class="delete-btn">Delete</button>
</a>

<?php endif; ?>

</div>

</div>

<?php endwhile; ?>

</div>


<!-- 🔥 MODAL DETAIL -->
<div id="bookModal" class="book-modal">

<div class="book-modal-content">

<span class="close-modal" onclick="closeBook()">×</span>

<h2 id="modalTitle"></h2>
<p id="modalAuthor"></p>

<div class="modal-divider"></div>

<p id="modalSynopsis"></p>

</div>

</div>


<!-- 🔥 MODAL BORROW -->
<div id="borrowModal" style="
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
  box-shadow:6px 6px 0 #000;
  text-align:center;
  ">

    <h3>Borrow Book</h3>

    <form method="POST" action="index.php?page=borrow_book">

      <input type="hidden" name="book_id" id="borrowBookId">

      <label>Tanggal Pinjam</label><br>
      <input type="date" name="pickup_date" required><br><br>

      <label>Metode</label><br>
      <select name="pickup_method">
        <option value="pickup">🏫 Pickup</option>
        <option value="delivery">🚚 Delivery</option>
      </select>

      <br><br>

      <button type="submit">Confirm Borrow</button>
      <button type="button" onclick="closeBorrowModal()">Cancel</button>

    </form>

  </div>

</div>


<script>

/* TOP PICK */
function scrollTopBooks(direction){
const carousel = document.getElementById("topCarousel");
carousel.scrollLeft += direction * 260;
}

/* BOOK MODAL */
function openBook(el){
document.getElementById("modalTitle").innerText = el.dataset.title;
document.getElementById("modalAuthor").innerText = el.dataset.author;
document.getElementById("modalSynopsis").innerText = el.dataset.synopsis || "No synopsis available.";
document.getElementById("bookModal").style.display = "flex";
}

function closeBook(){
document.getElementById("bookModal").style.display = "none";
}

/* BORROW MODAL */
function openBorrowModal(bookId){
document.getElementById("borrowModal").style.display = "flex";
document.getElementById("borrowBookId").value = bookId;
}

function closeBorrowModal(){
document.getElementById("borrowModal").style.display = "none";
}

/* CLOSE OUTSIDE */
window.onclick = function(event){
if(event.target.id === "bookModal"){
closeBook();
}
if(event.target.id === "borrowModal"){
closeBorrowModal();
}
}

/* ESC */
document.addEventListener("keydown", function(event){
if(event.key === "Escape"){
closeBook();
closeBorrowModal();
}
});

</script>

<?php require '../app/views/partials/footer.php'; ?>