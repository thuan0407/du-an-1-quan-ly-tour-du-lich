<?php require_once 'navbar.php'; ?>
<div class="content-wrapper">
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navbar Offcanvas - Quản lý Tour</title>
</head>
<body>

 
  <!-- Nội dung chính -->
  <div class="container mt-4">
    <h2>📊 Bảng điều khiển</h2>
    <p>Nhấn nút ☰ để mở thanh menu bên trái.</p>
  </div>
  
    <!-- Nội dung -->
  <div class="content">
    <h2 class="mb-4">📊 Thống kê tổng quan</h2>
    

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <i class="fa-solid fa-chart-column"></i> Doanh thu tour theo tháng
          </div>
          <div class="card-body">
            <canvas id="revenueChart" height="200"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-header bg-success text-white">
            <i class="fa-solid fa-chart-line"></i> Người dùng mới theo tuần
          </div>
          <div class="card-body">
            <canvas id="userChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('overlay');

    toggleBtn.addEventListener('click', () => {
      if (window.innerWidth <= 991) {
        // Mobile: mở sidebar trượt ra
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
      } else {
        // Desktop: thu gọn/mở rộng
        sidebar.classList.toggle('collapsed');
      }
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    });

    // --- Biểu đồ cột ---
    const ctxRevenue = document.getElementById('revenueChart');
    new Chart(ctxRevenue, {
      type: 'bar',
      data: {
        labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
        datasets: [{
          label: 'Doanh thu (triệu VNĐ)',
          data: [120, 150, 180, 220, 300, 400],
          backgroundColor: '#0d6efd'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: true, text: 'Biểu đồ doanh thu tour' }
        }
      }
    });

    // --- Biểu đồ đường ---
    const ctxUser = document.getElementById('userChart');
    new Chart(ctxUser, {
      type: 'line',
      data: {
        labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
        datasets: [{
          label: 'Người dùng mới',
          data: [45, 60, 80, 90],
          fill: true,
          borderColor: '#198754',
          backgroundColor: 'rgba(25,135,84,0.2)',
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: true, text: 'Biểu đồ người dùng mới' }
        }
      }
    });
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
