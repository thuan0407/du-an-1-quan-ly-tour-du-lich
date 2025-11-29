<div class="schedule-container">
  <h2>➕ Thêm Yêu cầu đặc biệt</h2>

  <form id="specialForm" method="POST">
    <div class="form-group">
      <label for="date">Ngày:</label>
      <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div class="form-group">
      <label for="content">Nội dung:</label>
      <textarea id="content" name="content" rows="4" required></textarea>
      <small id="contentError" style="color:red; display:none;"></small>
    </div>

    <input type="hidden" name="status" value="1">

    <button type="submit" name="submit_special_request" class="btn btn-primary">
      Thêm yêu cầu
    </button>
    <a href="?action=special_request_index&id_book_tour=<?= $id_book_tour ?>" class="btn btn-secondary">← Quay lại</a>
  </form>
</div>

<script>
document.getElementById('specialForm').addEventListener('submit', function (e) {
    let content = document.getElementById('content').value.trim();
    let errorBox = document.getElementById('contentError');
    errorBox.style.display = "none";
    errorBox.innerText = "";

    // Validate nội dung
    if (content.length === 0) {
        e.preventDefault();
        errorBox.innerText = "Nội dung không được để trống.";
        errorBox.style.display = "block";
        return;
    }

    if (content.length > 255) {
        e.preventDefault();
        errorBox.innerText = "Nội dung không được vượt quá 255 ký tự. Hiện tại: " + content.length;
        errorBox.style.display = "block";
        return;
    }
});
</script>


<style>
.schedule-container {
    max-width: 700px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}
.schedule-container h2 {
    text-align: center;
    color: #1e90ff;
    margin-bottom: 20px;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-group input, 
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 8px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}
.btn {
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    margin-right: 5px;
}
.btn-primary { background: #1e90ff; color: #fff; border: none; }
.btn-primary:hover { background: #0b6ecd; }
.btn-secondary { background: #ccc; color: #333; border: none; }
.btn-secondary:hover { background: #999; }
</style>
