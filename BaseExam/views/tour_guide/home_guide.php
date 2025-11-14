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
    

    /* Sidebar */
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

    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .sidebar h2 {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }

    .menu {
      list-style: none;
    }

    .menu li {
      padding: 15px 20px;
      cursor: pointer;
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

    /* Main content */
    .content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
      transition: margin-left 0.3s ease;
    }

    .content.shifted {
      margin-left: 0;
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

    .user-info {
      font-size: 14px;
      color: #555;
    }

    /* Hamburger button */
    .menu-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
      color: #1e90ff;
    }

    /* Nội dung từng phần */
    section {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }

    section.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(5px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
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
      }

      .menu-toggle {
        display: block;
      }

      header h1 {
        font-size: 20px;
      }
    }

  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>Hướng dẫn viên</h2>
    <ul class="menu">
        <li class="active"><a href="#" data-section="profile">Hồ sơ cá nhân</a></li>
      <li><a href="#" data-section="schedule">Xem lịch làm việc</a></li>
      <li><a href="#" data-section="booktour">Đặt tour</a></li>
      <li><a href="#" data-section="journal">Nhật ký tour</a></li>
      <li><a href="#" data-section="feedback">Phản hồi & đánh giá</a></li>
      <li><a href="#" data-section="list">Xem danh sách</a></li>
    </ul>
  </aside>

  <div class="content">
    <header>
      <span class="menu-toggle">☰</span>
      <h1>Bảng điều khiển</h1>
      <div class="user-info">Xin chào, <strong>Nguyễn Văn A</strong></div>
    </header>

    <section id="profile" class="active">
      <h2>🧑 Hồ sơ cá nhân</h2>
      <p>Thông tin hướng dẫn viên: họ tên, số điện thoại, kinh nghiệm, ngôn ngữ, v.v...</p>
    </section>

    <section id="schedule">
      <h2>🗓️ Lịch làm việc</h2>
      <p>Danh sách các tour bạn sẽ dẫn trong tuần này và tháng tới.</p>
    </section>

    <section id="booktour">
      <h2>🚌 Đặt tour</h2>
      <p>Trang cho phép hướng dẫn viên đăng ký hoặc nhận tour mới.</p>
    </section>

    <section id="journal">
      <h2>📖 Nhật ký tour</h2>
      <p>Ghi chép nhật ký hành trình, tình trạng khách, và các sự kiện trong tour.</p>
    </section>

    <section id="feedback">
      <h2>⭐ Phản hồi & Đánh giá</h2>
      <p>Xem phản hồi của khách du lịch, đánh giá tour và cải thiện chất lượng phục vụ.</p>
    </section>

    <section id="list">
      <h2>📋 Danh sách tour đã tham gia</h2>
      <p>Liệt kê toàn bộ tour mà hướng dẫn viên từng tham gia.</p>
    </section>
  </div>

  <script>
    const links = document.querySelectorAll('.menu a');
    const sections = document.querySelectorAll('section');
    const menuItems = document.querySelectorAll('.menu li');
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.menu-toggle');
    const content = document.querySelector('.content');

    // Đổi nội dung khi bấm menu
    links.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const target = link.dataset.section;

        sections.forEach(sec => sec.classList.remove('active'));
        document.getElementById(target).classList.add('active');

        menuItems.forEach(item => item.classList.remove('active'));
        link.parentElement.classList.add('active');

        // Ẩn sidebar sau khi chọn mục (trên mobile)
        sidebar.classList.remove('show');
      });
    });

    // Bật/tắt menu trên mobile
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });

    // Ẩn menu khi click ngoài
    document.addEventListener('click', e => {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
sidebar.classList.remove('show');
      }
    });
  </script>

</body>
</html>
