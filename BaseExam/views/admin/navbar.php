<?php
// navbar.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Sidebar</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0b1f2aa.js" crossorigin="anonymous"></script>

  <style>

    /* Sidebar */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #0d345bff;
      color: white;
      transform: translateX(-250px);
      transition: transform 0.3s ease;
      z-index: 1040;
      padding-top: 56px; /* để tránh navbar */
    }

    #sidebar.active {
      transform: translateX(0);
    }

    #sidebar a {
      color: #c3cfdcff;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      margin: 5px 0;
      border-radius: 5px;
    }

    #sidebar a:hover {
      background-color: #154a7fff;
      color: #fff;
    }

    /* Dịch nội dung sang phải khi sidebar mở */
    body.sidebar-open .content-wrapper {
      margin-left: 250px;
      transition: margin-left 0.3s ease;
    }

    /* Navbar */
    .navbar {
      z-index: 1050;
    }
    .content-wrapper {
        margin-left: 0;
        padding-top: 20px; /* tránh navbar che nội dung */
        transition: margin-left 0.3s ease;
    }
  </style>
</head>
<body >

  <!-- Navbar cố định trên cùng -->
  <!-- <nav class="navbar navbar-dark bg-dark fixed-top "> -->
  <nav class="navbar navbar-dark" style="background-color: #182e45ff;">
    <div class="container-fluid">
      <button id="sidebarToggle" class="btn btn-outline-light">
        <i class="fa-solid fa-bars"></i>
      </button>
      <a class="navbar-brand ms-2" href="?action=home_admin">Quản lý Tour</a>

      <!-- Search bar -->
      <form class="d-flex ms-auto" role="search">
       <input class="form-control me-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit"><i class="fa-solid fa-magnifying-glass"></i>Tìm</button>
      </form>
    </div>
  </nav>

  <!-- Sidebar -->
  <div id="sidebar">
    <h4 class="px-3 pt-3">Quản lý Tour</h4>
    <a href="#"><i class="fa-solid fa-users"></i> Quản lý nhân sự</a>
    <a href="#"><i class="fa-solid fa-map-location-dot"></i> Quản lý danh mục tour</a>
    <a href="#"><i class="fa-solid fa-ticket"></i> Quản lý tour</a>
    <a href="#"><i class="fa-solid fa-ticket"></i> Quản lý nhà cung cấp</a>
    <a href="#"><i class="fa-solid fa-ticket"></i> Quản lý đặt tour</a>

    <!-- Dropdown tài khoản -->
    <div class="mt-3 px-3">
      <a class="dropdown-toggle text-white text-decoration-none" data-bs-toggle="collapse" href="#accountMenu">
        <i class="fa-solid fa-user"></i> Tài khoản
      </a>
      <div class="collapse ps-3 mt-2" id="accountMenu">
        <a href="?action=login_admin">Đăng nhập</a>
        <a href="?action=guide_registration">Đăng ký</a>
        <a href="#">Đăng xuất</a>
      </div>
    </div>
  </div>


  <!-- Wrapper cho nội dung trang -->
  <div class="content-wrapper">
    <!-- Nội dung trang sẽ được include ở đây -->
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS điều khiển sidebar -->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    // Load trạng thái sidebar từ localStorage
    if(localStorage.getItem('sidebar-open') === 'true') {
      document.body.classList.add('sidebar-open');
      sidebar.classList.add('active');
    }

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      document.body.classList.toggle('sidebar-open');

      // Lưu trạng thái
      if(document.body.classList.contains('sidebar-open')) {
        localStorage.setItem('sidebar-open', 'true');
      } else {
        localStorage.setItem('sidebar-open', 'false');
      }
    });
  </script>

</body>
</html>
