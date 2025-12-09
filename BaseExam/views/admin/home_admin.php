<?php require_once 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thống kê Tour</title>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #f5f6fa;
    margin: 0;
  }

  .content-wrapper { padding: 20px; }

  h2 { color:#2f3640; margin-bottom:20px; }

  .stat-box {
    display:flex; gap:15px; flex-wrap:wrap;
  }

  .stat-card {
    flex:1;
    min-width:180px;
    padding:18px;
    border-radius:12px;
    color:white;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    transition:.2s;
  }
  .stat-card:hover {
    transform:translateY(-5px);
    box-shadow:0 6px 15px rgba(0,0,0,0.25);
  }
  .stat-card i { font-size:28px; margin-bottom:8px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="content-wrapper">
  
  <h2>📊 Bảng Thống kê</h2>
  <div class="stat-box">

    <div class="stat-card" style="background:#f1c40f;">
      <i class="fas fa-wallet"></i>
      <div>Tổng doanh thu</div>
      <strong><?= number_format($total_amount->total_money, 0, ',', '.') ?> VND</strong>
    </div>

    <div class="stat-card" style="background:#3498db;">
      <i class="fas fa-clock"></i>
      <div>Tour chờ duyệt</div>
      <strong><?= $total_book_tour_1 ?></strong>
    </div>

    <div class="stat-card" style="background:#2ecc71;">
      <i class="fas fa-route"></i>
      <div>Tour đang hoạt động</div>
      <strong><?= $total_book_tour_2 ?></strong>
    </div>

    <div class="stat-card" style="background:#e74c3c;">
      <i class="fas fa-check"></i>
      <div>Tour đã kết thúc</div>
      <strong><?= $total_book_tour_3 ?></strong>
    </div>

  </div>

  <h2 class="mt-4">📈 Doanh thu theo tháng</h2>
  <canvas id="revenueChart" height="120"></canvas>

</div>

<script>
const labels = <?= $labels ?>;
const dataRevenue = <?= $data ?>;

new Chart(document.getElementById("revenueChart"), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Doanh thu (VND)',
      data: dataRevenue,
      borderColor: 'rgba(30,144,255,1)',
      backgroundColor: 'rgba(30,144,255,0.2)',
      tension: 0.3,
      fill:true,
      pointRadius:4,
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        max: 500000000,
        ticks:{
          callback:(v)=>v.toLocaleString('vi-VN')+"₫"
        }
      }
    }
  }
});
</script>

</body>
</html>
