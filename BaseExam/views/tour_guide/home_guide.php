
<?php $guide = $this->model->find_tour_guide($guide_id);?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giao diện Hướng dẫn viên</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    body {
      background: #f5f6fa;
      color: #333;
      display: flex;
      min-height: 100vh;
      flex-direction: row;
    }

    .sidebar {
      width: 250px;
      background-color: #1e90ff;
      color: white;
      padding-top: 20px;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .menu li {
      padding: 15px 20px;
      transition: background 0.2s;
    }

    .menu li:hover,
    .menu li.active {
      background-color: #0c65c2;
    }

    .menu li a {
      color: white;
      text-decoration: none;
      display: block;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
      width: calc(100% - 250px);
    }

    header {
      background: white;
      padding: 15px 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    header h1 {
      font-size: 22px;
      color: #1e90ff;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        position: fixed;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
        width: 100%;
      }

      .menu-toggle {
        display: block !important;
      }
    }

    .menu-toggle {
      display: none;
      font-size: 26px;
      cursor: pointer;
      color: #1e90ff;
    }
    .menu {
    list-style: none;
    padding-left: 0;
}

  </style>
</head>
<body>

  <aside class="sidebar">
    <h2 style="text-align:center; margin-bottom: 20px;">Hướng dẫn viên</h2>
    <ul class="menu">
        <li class="<?= ($action=='home_guide') ? 'active' : '' ?>">
            <a href="?action=home_guide">Hồ sơ cá nhân</a>
        </li>

        <li class="<?= ($action=='schedule_guide') ? 'active' : '' ?>">
            <a href="?action=schedule_guide">Xem lịch làm việc</a>
        </li>

        <!-- <li class="<?= ($action=='guide_Alltour') ? 'active' : '' ?>">
            <a href="?action=guide_Alltour">Đặt tour</a>
        </li> -->

        <li class="<?= ($action=='guide_pending_tour') ? 'active' : '' ?>">
            <a href="?action=guide_pending_tour">Tour chờ duyệt</a>
        </li>
    </ul>
  </aside>

  <div class="content">
    <header>
      <span class="menu-toggle">☰</span>
      <h1>Bảng điều khiển</h1>

      <div class="user-info">
          Xin chào, <strong><?= htmlspecialchars($guide->name) ?> 👋</strong>
          | <a href="?action=logout_guide" style="color:red;" 
            onclick="return confirm('Bạn có chắc muốn đăng xuất không?');">
            Đăng xuất
          </a>
      </div>
    </header>

    <!-- Nội dung view được load từ controller -->
    <section>
      <?php 
          if (isset($viewFile)) {
              include $viewFile;
          } else {
              echo "<p>Không tìm thấy view được truyền từ controller!</p>";
          }
      ?>
    </section>

  </div>

  <script>
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.menu-toggle');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });

    document.addEventListener('click', e => {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('show');
      }
    });
  </script>

</body>
</html>
