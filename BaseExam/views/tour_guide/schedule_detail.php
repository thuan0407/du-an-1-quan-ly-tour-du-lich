





<div class="detail-box">
  <h2>📌 Chi tiết lịch làm việc</h2>
  <div style="width:90%; margin-left:50px;">
                <div class="timeline">
                    <?php foreach ($arr_merged as $index => $label): ?>
                        <div class="timeline-step <?= ($index + 1) <= $step ? 'active' : '' ?>">
                            <div class="circle"></div>
                            <div class="label"><?= $label ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

          <form action="" method="post" enctype="multipart/form-data">
            <button class="btn btn-success" type="submit" name="add" onclick="return confirm('Bạn có chắc là đã đến địa chưa?')">Đã đến</button>
            <button class="btn btn-danger" type="submit" name="back" onclick="return confirm('Bạn có chắc là muốn lùi lại không?')">Lùi lại</button>
          </form>
    

  <p><strong>Tên tour:</strong> <?= htmlspecialchars($detail->tour_name) ?></p>
  <p><strong>Mô tả tour:</strong> <?= nl2br(htmlspecialchars($detail->tour_description)) ?></p>

  <p><strong>Số ngày:</strong> <?= $detail->days ?? 'N/A' ?></p>
  <p><strong>Số đêm:</strong> <?= $detail->nights ?? 'N/A' ?></p>
  
  <p><strong>Ngày bắt đầu:</strong> <?= $detail->start_date ?></p>
  <p><strong>Ngày kết thúc:</strong> <?= $detail->end_date ?></p>

    <p><strong>Điểm khởi hành:</strong> <?= $detail->start_location ?></p>
  <p><strong>Điểm kết thúc:</strong> <?= $detail->end_location ?></p>

  <p><strong>Chi phí phát sinh:</strong> <?= number_format($detail->incidental_costs ?? 0) ?> VNĐ</p>
  <p><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($detail->note)) ?></p>

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
            <td><?= htmlspecialchars($cust->list_customer) ?></td>
            <td><?= htmlspecialchars($cust->quantity) ?></td>
            <td><?= nl2br(htmlspecialchars($cust->note)) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Chưa có khách hàng nào.</p>
  <?php endif; ?>

  <a href="?action=schedule_guide" class="back-btn">← Quay lại</a>
</div>
<style>
    .detail-box {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  max-width: 700px;
  margin: 0 auto;
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
.customer-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

.customer-table th, .customer-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.customer-table th {
  background-color: #f2f2f2;
}

.customer-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.customer-table tr:hover {
  background-color: #f1f1f1;
}


</style>
<style>
    .timeline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        margin: 40px 0;
    }

    .timeline::before {
        content: "";
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 4px;
        background: #ddd;     /* màu đường */
        z-index: 1;
    }

    .timeline-step {
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .timeline-step .circle {
        width: 25px;
        height: 25px;
        background: #ccc;
        border-radius: 50%;
        margin: 0 auto;
        transition: 0.3s;
    }

    .timeline-step.active .circle {
        background: #28a745; /* màu xanh sáng */
    }

    .timeline-step .label {
        margin-top: 8px;
        font-size: 14px;
        color: #555;
    }

    .timeline-step.active .label {
        font-weight: bold;
        color: #28a745;
    }
</style>