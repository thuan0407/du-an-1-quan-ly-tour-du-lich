<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="profile-container">
<div class="profile-avatar">
    <img src="<?= BASE_ASSETS_UPLOADS .htmlspecialchars($guide->img) ?>" alt="Avatar">
</div>
  <div class="profile-info">
    <p><strong>Họ tên:</strong> <?= $guide->name ?></p>
    <p><strong>Số điện thoại:</strong> 0<?= $guide->phone_number ?></p>
    <p><strong>Loại hướng dẫn viên:</strong> <?= $guide->type_guide == 1 ? 'Nội địa' : 'Ngoại địa' ?></p>
    <p><strong>Kinh nghiệm:</strong> <?= $guide->years_experience ?> năm</p>
    <p><strong>Ngoại ngữ:</strong> <?= $guide->foreign_languages ?></p>
    <p><strong>Bằng cấp:</strong> <?= $guide->certificate ?></p>
    <p><strong>Giới tính:</strong> <?= $guide->sex == 1 ? 'Nam' : 'Nữ' ?></p>
    <p><strong>Sức khỏe:</strong> <?= $guide->health ?></p>
    <p><strong>Năm sinh:</strong> <?= $guide->year_birth ?></p>

    <a href="?action=edit_profile" id="edit-profile-btn">Chỉnh sửa thông tin</a>


  </div>
</div>


</body>
<style>
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    background-color: #f5f6fa;
    color: #333;
    padding: 20px;
  }

  .profile-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    padding: 30px;
  }

  .profile-avatar {
    flex: 0 0 150px;
    margin-right: 30px;
    text-align: center;
  }

  .profile-avatar img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #1e90ff;
  }

  .profile-info {
    flex: 1;
  }

  .profile-info p {
    font-size: 16px;
    margin: 8px 0;
  }

  .profile-info p strong {
    width: 140px;
    display: inline-block;
  }

  #edit-profile-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 25px;
    background-color: #1e90ff;
    color: white;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    transition: background 0.3s ease;
  }

  #edit-profile-btn:hover {
    background-color: #0c65c2;
  }

  /* Responsive cho mobile */
  @media (max-width: 600px) {
    .profile-container {
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }

    .profile-avatar {
      margin-right: 0;
      margin-bottom: 20px;
    }

    .profile-info p strong {
      width: 100px;
    }
  }

  /* Thông báo cập nhật */
  .update-success {
    margin-top: 15px;
    color: green;
    font-weight: bold;
  }
</style>
<?php if(!empty($_SESSION['update_success'])): ?>
    <p style="color: green;">Cập nhật thông tin thành công!</p>
    <?php unset($_SESSION['update_success']); ?>
<?php endif; ?>

</html>