<?php $guide = $this->model->find_tour_guide($guide_id); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hướng dẫn viên – Dashboard</title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    body {
      background: #f0f2f5;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* SIDEBAR */
    .sidebar {
      width: 260px;
      background: linear-gradient(180deg, #1e90ff, #0b67c1);
      color: white;
      padding-top: 25px;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1000;
      box-shadow: 3px 0 8px rgba(0,0,0,0.15);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 22px;
      font-weight: 600;
    }

    .menu {
      list-style: none;
      padding-left: 0;
    }

    .menu li {
      padding: 12px 20px;
      transition: 0.25s;
      font-size: 16px;
    }

    .menu li a {
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .menu li:hover,
    .menu li.active {
      background: rgba(255, 255, 255, 0.2);
      cursor: pointer;
    }

    /* MAIN CONTENT */
    .content {
      margin-left: 260px;
      padding: 20px;
      width: calc(100% - 260px);
    }

    /* HEADER */
    header {
      background: white;
      padding: 15px 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 10px;
      z-index: 999;
    }

    header h1 {
      font-size: 20px;
      font-weight: 600;
      color: #1e90ff;
    }

    .user-info {
      font-size: 15px;
    }

    .user-info strong {
      color: #1e90ff;
    }

    /* MOBILE */
    .menu-toggle {
      display: none;
      font-size: 28px;
      cursor: pointer;
      color: #1e90ff;
      margin-right: 10px;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: 0.3s;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
        width: 100%;
      }

      .menu-toggle {
        display: block;
      }
    }
  </style>
</head>

<body>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h2>Hướng dẫn viên</h2>

    <ul class="menu">
      <li class="<?= ($action=='home_guide') ? 'active' : '' ?>">
        <a href="?action=home_guide">👤 Hồ sơ cá nhân</a>
      </li>

      <li class="<?= ($action=='schedule_guide') ? 'active' : '' ?>">
        <a href="?action=schedule_guide">📅 Lịch làm việc</a>
      </li>

      <li class="<?= ($action=='guide_pending_tour') ? 'active' : '' ?>">
        <a href="?action=guide_pending_tour">⏳ Tour chờ duyệt</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="content">

    <header>
      <span class="menu-toggle">☰</span>
      <h1>Bảng điều khiển</h1>

      <div class="user-info">
        Xin chào, <strong><?= htmlspecialchars($guide->name) ?></strong> 👋 |
        <a href="?action=logout_guide" style="color:red; text-decoration:none;"
           onclick="return confirm('Bạn có chắc muốn đăng xuất?');">
            Đăng xuất
        </a>
      </div>
    </header>

    <section class="page-content">
      <?php 
        if (isset($viewFile)) {
          include $viewFile;
        } else {
          echo "<p>Không tìm thấy view được truyền từ controller!</p>";
        }
      ?>
    </section>

  </div>

  <!-- JS -->
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
