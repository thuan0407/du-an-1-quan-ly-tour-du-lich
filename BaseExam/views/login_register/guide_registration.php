<?php require_once './views/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký người dùng</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .register-card {
      background-color: #fff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      width: 400px;
    }

    .register-card h4 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
      color: #333;
    }

    label {
      font-weight: 500;
      color: #444;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"],
    select {
      margin-bottom: 15px;
    }

    .btn-primary {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      font-weight: 600;
      background-color: #5563DE;
      border: none;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #3e4bbf;
    }

    .register-card a {
      display: block;
      text-align: center;
      margin-top: 15px;
      text-decoration: none;
      color: #5563DE;
      font-weight: 500;
    }

    .register-card a:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      text-align: center;
      font-size: 14px;
    }

    .success {
      color: green;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <form method="post" enctype="multipart/form-data" class="register-card">
    <h4>Đăng ký người dùng</h4>

    <div class="mb-3">
      <label for="">Tên</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label for="">Email</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label for="">Số điện thoại</label>
      <input type="text" 
             name="phone_number" 
             class="form-control" 
             required 
             pattern="\d{10,}" 
             title="Số điện thoại phải ít nhất 10 chữ số">
    </div>

    <div class="mb-3">
      <label for="">Giới tính</label>
      <select name="sex" class="form-select" required>
        <option value="" disabled selected>Chọn giới tính</option>
        <option value="1">Nam</option>
        <option value="2">Nữ</option>
        <option value="3">Khác</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="">Mật khẩu</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label for="">Ảnh đại diện</label>
      <input type="file" name="img" class="form-control">
    </div>

    <span class="error"><?=$err?></span>
    <span class="success"><?=$success?></span>

    <button type="submit" class="btn btn-primary" name="registration">Đăng ký</button>
    <a href="?action=login_admin">Đăng nhập</a>
  </form>

</body>
</html>
