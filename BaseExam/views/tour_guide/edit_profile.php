<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chỉnh sửa thông tin cá nhân</title>
<style>
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    background-color: #f5f6fa;
    color: #333;
    padding: 20px;
  }

  .edit-profile-container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }

  .edit-profile-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #1e90ff;
  }

  .edit-profile-container form p {
    margin-bottom: 20px;
  }

  .edit-profile-container label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
  }

  .edit-profile-container input[type="text"],
  .edit-profile-container input[type="password"],
  .edit-profile-container select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    transition: border 0.3s;
  }

  .edit-profile-container input[type="text"]:focus,
  .edit-profile-container input[type="password"]:focus,
  .edit-profile-container select:focus {
    border-color: #1e90ff;
    outline: none;
  }

  .edit-profile-container button,
  .edit-profile-container a.cancel-btn {
    display: inline-block;
    padding: 10px 25px;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s;
  }

  .edit-profile-container button {
    background-color: #1e90ff;
    color: #fff;
    margin-right: 10px;
  }

  .edit-profile-container button:hover {
    background-color: #0c65c2;
  }

  .edit-profile-container a.cancel-btn {
    background-color: #ccc;
    color: #333;
  }

  .edit-profile-container a.cancel-btn:hover {
    background-color: #999;
    color: #fff;
  }

  .error-msg {
    color: red;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
  }

  @media (max-width: 600px) {
    .edit-profile-container {
      padding: 20px;
    }
  }
</style>
</head>
<body>

<div class="edit-profile-container">


  <?php if (!empty($err)): ?>
    <p class="error-msg"><?= htmlspecialchars($err) ?></p>
  <?php endif; ?>

<form action="?action=edit_profile" method="POST" enctype="multipart/form-data">
    <p>
      <label for="name">Họ tên:</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($guide->name) ?>" required>
    </p>

    <p>
      <label for="password">Mật khẩu mới (để trống nếu không đổi):</label>
      <input type="password" id="password" name="password">
    </p>
    <p>
      <label for="year_birth">Ngày sinh:</label>
<input type="date" id="year_birth" name="year_birth" value="<?= htmlspecialchars($guide->year_birth) ?>" required>
    </p>
    <p>
      <label for="sex">Giới tính:</label>
      <select name="sex" id="sex" required>
        <option value="1" <?= $guide->sex == 1 ? 'selected' : '' ?>>Nam</option>
        <option value="2" <?= $guide->sex == 2 ? 'selected' : '' ?>>Nữ</option>
      </select>
    </p>

    <p>
      <label for="phone_number">Số điện thoại:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($guide->phone_number) ?>" required>
    </p>

    <p>Ảnh hiện tại:</p>
    <img src="assets/uploads/<?= htmlspecialchars($guide->img) ?>" width="120" style="border-radius:6px;margin-bottom:10px">

    <p>Chọn ảnh mới:</p>
    <input type="file" name="img" accept="image/*">

    <p>
      <button type="submit" name="update_profile">Cập nhật thông tin</button>
      <a href="?action=home_guide" class="cancel-btn">Hủy</a>
    </p>
</form>
</div>

</body>
</html>
