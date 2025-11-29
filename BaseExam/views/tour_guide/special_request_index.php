<div class="schedule-container">
  <h2>📝 Danh sách Yêu cầu đặc biệt</h2>

  <p>
    <a href="?action=special_request_add&id_book_tour=<?= $id_book_tour ?>" class="btn btn-primary">
      Thêm Yêu cầu đặc biệt
    </a>
  </p>
  <div class="filter-box">
    <label>Lọc trạng thái:</label>
    <select id="filterStatus">
        <option value="">Tất cả</option>
        <option value="1">Đang tiến hành</option>
        <option value="2">Đã hoàn thành</option>
        <option value="3">Đã hủy</option>
    </select>
</div>


  <div class="table-wrapper">
    <table class="schedule-table">
      <thead>
        <tr>
          <th>Mã yêu cầu</th>
          <th>Ngày</th>
          <th>Nội dung</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($special_requests)): ?>
          <?php $stt = 1; ?>
          <?php foreach($special_requests as $req): ?>
            <tr>
              <td><?= $stt++ ?></td>
              <td><?= $req['date'] ?></td>
              <td><?= htmlspecialchars($req['content']) ?></td>
              <td>
                <form method="POST" action="?action=update_special_request_status&id=<?= $req['id'] ?>">
                <input type="hidden" name="id_book_tour" value="<?= $req['id_book_tour'] ?>">
                <select name="status" class="status-select status-<?= $req['status'] ?>" onchange="this.form.submit()">
                    <option value="1" <?= $req['status']==1?'selected':'' ?>>Đang tiến hành</option>
                    <option value="2" <?= $req['status']==2?'selected':'' ?>>Đã hoàn thành</option>
                    <option value="3" <?= $req['status']==3?'selected':'' ?>>Đã hủy</option>
                </select>
                </form>
              </td>
              <td>
                <a href="?action=special_request_edit&id=<?= $req['id'] ?>&id_book_tour=<?= $req['id_book_tour'] ?>">Sửa yêu cầu</a> 
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5">Chưa có yêu cầu đặc biệt nào.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  <a href="?action=schedule_guide" class="back-btn">← Quay lại</a>
  </div>
</div>

<style>
  .filter-box {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
}

#filterStatus {
    padding: 6px 10px;
    border-radius: 5px;
    border: 1px solid #aaa;
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

.back-btn:hover { background: #0b6ecd; }
.schedule-container {
    max-width: 1200px;
    margin: 20px auto;
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}

.schedule-container h2 {
    text-align: center;
    color: #1e90ff;
    margin-bottom: 20px;
}

.btn-primary {
    display: inline-block;
    background-color: #1e90ff;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
}
.btn-primary:hover {
    background-color: #0b6ecd;
}

.table-wrapper {
    overflow-x: auto;
}

.schedule-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
}

.schedule-table th,
.schedule-table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

.schedule-table th {
    background-color: #1e90ff;
    color: white;
}

.schedule-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.schedule-table tr:hover {
    background-color: #d6e6ff;
}

/* Trạng thái select */
.status-select {
    padding: 5px 8px;
    border-radius: 5px;
    font-weight: bold;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: opacity 0.2s;
}
.status-select:hover { opacity: 0.9; }

/* Màu trạng thái */
.status-1 { background-color: #f0ad4e; } /* Đang tiến hành - cam */
.status-2 { background-color: #5cb85c; } /* Đã hoàn thành - xanh */
.status-3 { background-color: #d9534f; } /* Đã hủy - đỏ */

/* Link Hành động */
.schedule-table a {
    color: #1e90ff;
    text-decoration: none;
    font-weight: bold;
}
.schedule-table a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 600px) {
    .schedule-container {
        padding: 15px 20px;
    }

    .schedule-table th,
    .schedule-table td {
        padding: 8px 10px;
        font-size: 14px;
    }

    .status-select {
        padding: 4px 6px;
    }
}
</style>
<script>
document.getElementById("filterStatus").addEventListener("change", function () {
    const value = this.value;

    document.querySelectorAll(".schedule-table tbody tr").forEach(row => {
        const statusSelect = row.querySelector("select[name='status']");
        if (!statusSelect) return;

        const rowStatus = statusSelect.value;

        // Nếu chọn "Tất cả"
        if (value === "") {
            row.style.display = "";
        } else {
            row.style.display = (rowStatus === value) ? "" : "none";
        }
    });
});
</script>
