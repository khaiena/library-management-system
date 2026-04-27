<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<div class="form-container">

<h2>Add Book</h2>

<!-- 📷 SCANNER -->
<h3>📷 Scan ISBN</h3>

<button type="button" onclick="toggleScanner()" class="scan-btn">
  ⛔ Stop Camera
</button>

<div id="scanner"></div>

<p>ISBN: <span id="isbn-result">-</span></p>

<!-- FORM -->
<form method="POST" action="index.php?page=create_book">

<input type="hidden" id="isbn-input">

<label>Title</label>
<input type="text" name="title" required>

<label>Author</label>
<input type="text" name="author" required>

<label>Year</label>
<input type="number" name="year">

<label>Synopsis</label>
<textarea name="synopsis" rows="4"></textarea>

<label>Category</label>

<select name="category_id">
<?php while($cat = $categories->fetch_assoc()): ?>
<option value="<?= $cat['id'] ?>">
<?= $cat['name'] ?>
</option>
<?php endwhile; ?>
</select>

<div class="checkbox-row">
<input type="checkbox" name="available" checked>
<label>Available</label>
</div>

<button type="submit">📚 Add Book</button>

<a href="index.php?page=books">← Back to Library</a>

</form>

</div>

<script src="https://unpkg.com/@ericblade/quagga2/dist/quagga.min.js"></script>
<script>

let isScanning = false;
let lastScan = null;

// START
function startScanner(){

    Quagga.init({
        inputStream: {
            type: "LiveStream",
            target: document.querySelector('#scanner'),
            constraints: {
                facingMode: "environment"
            }
        },
        decoder: {
            readers: [
                "ean_reader",
               
            ]
        },
        locate: true
    }, function(err) {
        if (err) {
            console.log(err);
            alert("Camera error 😭");
            return;
        }
        Quagga.start();
        isScanning = true;
        document.querySelector(".scan-btn").innerText = "⛔ Stop Camera";
    });

    Quagga.onDetected(onDetected);
}

// STOP
function stopScanner(){
    Quagga.stop();
    isScanning = false;
    document.querySelector(".scan-btn").innerText = "📷 Start Camera";
}

// TOGGLE
function toggleScanner(){
    if(isScanning){
        stopScanner();
    } else {
        startScanner();
    }
}

// 🔥 VALIDASI ISBN
function isValidISBN(code){
    return (
        code.length === 13 &&
        (code.startsWith("978") || code.startsWith("979"))
    );
}

// DETECT
function onDetected(result){

    let code = result.codeResult.code;
    let confidence = result.codeResult.decodedCodes;

    // 🔥 minimal akurasi
    if(result.codeResult.startInfo.error > 0.3){
        console.log("LOW CONFIDENCE, SKIP");
        return;
    }

    if(!isValidISBN(code)){
        console.log("INVALID:", code);
        return;
    }

    if(code === lastScan){
        return;
    }
    lastScan = code;

    console.log("VALID ISBN:", code);

    document.getElementById("isbn-result").innerText = code;
    document.getElementById("isbn-input").value = code;

    fetchISBN(code);

    stopScanner();
}


// 🌐 FETCH API
function fetchISBN(isbn){

  fetch("index.php?page=isbn_lookup&isbn=" + isbn)
    .then(res => {
        if(!res.ok){
            throw new Error("HTTP error");
        }
        return res.json();
    })
    .then(data => {

      if(data.error){
        document.querySelector("input[name='title']").value = "Book ISBN: " + isbn;
        document.querySelector("input[name='author']").value = "-";
        document.querySelector("input[name='year']").value = "";
        document.querySelector("textarea[name='synopsis']").value = "No data found 😭";
        return;
      }

      document.querySelector("input[name='title']").value = data.title || '';
      document.querySelector("input[name='author']").value = data.author || '';
      document.querySelector("input[name='year']").value = data.year || '';
      document.querySelector("textarea[name='synopsis']").value =
        (data.synopsis || '').substring(0, 1000);

    })
    .catch(err => {
      console.log("FETCH ERROR:", err);
      alert("Error fetch ISBN 😭");
    });
}

// AUTO START
startScanner();

</script>
<?php require '../app/views/partials/footer.php'; ?>