<?php require '../app/views/partials/header.php'; ?>
<?php require '../app/views/partials/navbar.php'; ?>

<div class="dashboard">

<!-- HEADER -->
<div class="dashboard-header">

  <h1 class="dashboard-title">Dashboard</h1>

  <div class="dashboard-actions">
    <a href="index.php?page=card" class="add-btn">
      My Card
    </a>
  </div>

</div>

<!-- STATS -->
<div class="stats-grid">

  <div class="stat-card">
    <div class="stat-label">Total Books</div>
    <div class="stat-value"><?= $totalBooks ?></div>
  </div>

  <div class="stat-card">
    <div class="stat-label">Borrowed Books</div>
    <div class="stat-value"><?= $borrowedBooks ?></div>
  </div>

</div>

<!-- CHART -->
<div class="chart-card">

  <h3>Borrowing Statistics</h3>

  <canvas id="chart"></canvas>

</div>

</div>


<?php

$months = [
1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",
7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec"
];

$data = [];

foreach($months as $m => $name){
  $data[] = $stats[$m] ?? 0;
}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {

type: 'bar',

data: {
labels: <?= json_encode(array_values($months)) ?>,
datasets: [{
label: 'Borrowings',
data: <?= json_encode($data) ?>,
backgroundColor:"#14b8a6"
}]
},

options:{
plugins:{
legend:{
labels:{color:"#000"}
}
},
scales:{
x:{
ticks:{color:"#000"},
grid:{color:"#ddd"}
},
y:{
ticks:{color:"#000"},
grid:{color:"#ddd"}
}
}
}

});

</script>

<?php require '../app/views/partials/footer.php'; ?>