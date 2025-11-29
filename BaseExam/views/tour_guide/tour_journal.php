<div class="diary-container">
  <h2>📔 Nhật ký tour</h2>

  <!-- Form tạo nhật ký -->
  <form action="" method="POST" enctype="multipart/form-data" class="diary-form">
    <div class="form-group">
      <label for="content">Nội dung nhật ký <span style="color:red;">*</span></label>
      <textarea id="content" name="content" placeholder="Nhập nội dung nhật ký..." required></textarea>
    </div>

    <div class="form-group">
      <label for="evaluation">Đánh giá nhà cung cấp</label>
      <input type="text" id="evaluation" name="service_provider_evaluation" placeholder="Nhập đánh giá nhà cung cấp">
    </div>

    <div class="form-group">
      <label for="note">Ghi chú (tùy chọn)</label>
      <textarea id="note" name="note" placeholder="Nhập ghi chú..."></textarea>
    </div>

    <div class="form-group">
      <label for="img">Ảnh minh họa</label>
      <input type="file" id="img" name="img" accept="image/*" onchange="previewImage(event)">
      <img id="preview" style="max-width:150px; display:none; margin-top:10px; border-radius:5px;">
    </div>

    <button type="submit" name="submit_diary">Tạo nhật ký</button>
  </form>

  <hr>

  <!-- Danh sách nhật ký -->
  <?php if (!empty($diaries ?? [])): ?>
    <?php foreach ($diaries as $d): ?>
      <div class="diary-card">
        <div class="diary-header">
          <span class="diary-date"><?= htmlspecialchars($d->date ?? '') ?></span>
        </div>
        <div class="diary-body">
          <p><strong>Nội dung:</strong> <?= nl2br(htmlspecialchars($d->content ?? '')) ?></p>
          <p><strong>Đánh giá nhà cung cấp:</strong> <?= nl2br(htmlspecialchars($d->service_provider_evaluation ?? '')) ?></p>
          <?php if (!empty($d->note)): ?>
            <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($d->note)) ?></p>
          <?php endif; ?>
          <?php if (!empty($d->img)): ?>
            <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($d->img) ?>" 
                 alt="Ảnh nhật ký" class="diary-img">
          <?php endif; ?>
  <!-- xóa nhật ký (có thể dùng đến) -->
<!-- <div class="delete-icon">
  <a href="?action=delete_diary&id=<?= $d->id ?>&schedule_id=<?= $_GET['schedule_id'] ?>"
     onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');">
     🗑️
  </a>
</div> -->
        </div>
      </div>
    <?php endforeach; ?>
  <a href="?action=schedule_guide" class="back-btn">← Quay lại</a>

  <?php else: ?>
    <p>Chưa có nhật ký nào.</p>
  <?php endif; ?>
</div>

<style>
.diary-container {
  max-width: 800px;
  margin: 20px auto;
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  font-family: "Segoe UI", Arial, sans-serif;
}

.diary-container h2 {
  text-align: center;
  color: #1e90ff;
  margin-bottom: 20px;
}

.diary-form .form-group {
  margin-bottom: 15px;
}

.diary-form label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
  color: #333;
}

.diary-form textarea,
.diary-form input[type="text"],
.diary-form input[type="file"] {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
  font-family: inherit;
}

.diary-form button {
  padding: 10px 25px;
  background: #1e90ff;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 15px;
  transition: background 0.3s;
}

.diary-form button:hover {
  background: #0c65c2;
}

.diary-card {
  border: 1px solid #ddd;
  border-radius: 10px;
  margin-bottom: 20px;
  padding: 15px;
  background: #f9f9f9;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.diary-card .diary-header {
  font-weight: bold;
  color: #1e90ff;
  margin-bottom: 10px;
}

.diary-card .diary-img {
  max-width: 100%;
  border-radius: 8px;
  margin-top: 10px;
  display: block;
}
.diary-img {
    max-width: 200px;      /* tối đa ngang 200px */
    max-height: 200px;     /* tối đa cao 200px */
    display: block;
    margin-top: 10px;
    border-radius: 5px;
    object-fit: contain;    /* giữ toàn bộ ảnh trong khung, không cắt */
    background: #f0f0f0;   /* màu nền khi ảnh không đủ đầy khung */
}

@media (max-width: 600px) {
  .diary-container { padding: 15px; }
  .diary-form textarea, .diary-form input[type="text"], .diary-form input[type="file"] {
    font-size: 13px;
    padding: 8px;
  }
  .diary-form button { padding: 8px 20px; font-size: 14px; }
}
.back-btn {
  display: inline-block;
  margin-top: 15px;
  padding: 8px 18px;
  background: #1e90ff;
  color: #fff;
  border-radius: 6px;
  text-decoration: none;
}
.delete-icon {
  text-align: right;
  font-size: 20px;
  cursor: pointer;
}

.delete-icon a {
  color: #ff4d4d;
  text-decoration: none;
}

.delete-icon a:hover {
  color: #d93636;
}

.back-btn:hover { background: #0b6ecd; }
</style>

<script>
function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function(){
    const output = document.getElementById('preview');
    output.src = reader.result;
    output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>
