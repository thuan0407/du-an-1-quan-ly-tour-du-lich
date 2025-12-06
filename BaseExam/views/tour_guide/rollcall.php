 <h3>👥 Danh sách khách hàng</h3>

  <?php if (!empty($detail->customers)): ?>
    <table class="customer-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên khách</th>
          <th>SĐT</th>
          <th>Danh sách khách</th>
          <th>Số lượng</th>
          <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detail->customers as $index => $cust): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($detail->CusName) ?></td>
            <td>0<?= htmlspecialchars($detail->CusPhone) ?></td>
            <td>
              <img src="<?= './assets/uploads/' . $cust->list_customer ?>"
                  style="width:120px; cursor:pointer;"
                  onclick="showImg(this.src)">
          </td>
            <td><?= htmlspecialchars($cust->quantity) ?></td>
            <td><?= nl2br(htmlspecialchars($cust->note)) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Chưa có khách hàng nào.</p>
  <?php endif; ?>


<div class="container mt-4">

    <h2 class="mb-3">Điểm danh</h2>

    <!-- ==================== FORM ĐIỂM DANH ==================== -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Cập nhật điểm danh
        </div>
        <div class="card-body">

            <form action="?action=roll_call_update" method="POST">

                <input type="hidden" name="id_departure_schedule" value="<?= $id_departure_schedule ?>">



                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"><?= $rollCall['note'] ?? '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <?= isset($rollCall) ? 'Cập nhật điểm danh' : 'Thực hiện điểm danh' ?>
                </button>
                
            </form>

        </div>
    </div>


    <!-- ==================== DANH SÁCH ĐIỂM DANH ==================== -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            Lịch sử điểm danh
        </div>

        <div class="card-body">
            <?php if (!empty($rollCalls)): ?>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Lượt điểm danh</th>

                            <th>Ngày điểm danh</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rollCalls as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td><?= date('Y-m-d H:i:s', strtotime($row['date'])) ?></td>
                                <td><?= !empty($row['note']) ? $row['note'] : "<i>Không có</i>" ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p class="text-muted">Chưa có lịch sử điểm danh nào.</p>
            <?php endif; ?>
        </div>
    </div>

</div>
<style>
    /* ===========================
   CSS cho danh sách khách hàng
============================= */
.customer-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.customer-table th, .customer-table td {
    padding: 12px 15px;
    text-align: center;
    border: 1px solid #ddd;
    font-size: 14px;
}

.customer-table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.customer-table tbody tr:hover {
    background-color: #f4f4f4;
}

.customer-table td img {
    max-width: 120px;
    max-height: 120px;
    cursor: pointer;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.customer-table td img:hover {
    transform: scale(1.1);
}

.customer-table td {
    vertical-align: middle;
}

/* ===========================
   CSS cho ghi chú dài
============================= */
.customer-table .note {
    white-space: normal;
    word-wrap: break-word;
    line-height: 1.5;
}

/* ===========================
   Thêm style cho button chỉnh sửa (nếu có)
============================= */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: #218838;
}

/* ===========================
   Style cho alert khi không có khách
============================= */
.customer-table p {
    text-align: center;
    font-size: 16px;
    color: #555;
}

</style>
<div id="popup" onclick="this.style.display='none'" 
     style="display:none; position:fixed; inset:0; background:#000c; z-index:9999;">
    <img id="popupImg" style="max-width:90%; max-height:90%; margin:auto; display:block;">
</div>

<script>
function showImg(src){
    popupImg.src = src;
    popup.style.display = "flex";
}
</script>
