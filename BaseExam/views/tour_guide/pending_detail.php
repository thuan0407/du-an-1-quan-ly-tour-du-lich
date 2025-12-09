
<div class="detail-box">
  <h2>📌 Chi tiết tour chờ duyệt</h2>

  <p><strong>Tên tour:</strong> <?= htmlspecialchars($detail->tour_name) ?></p>

  <p><strong>Mô tả tour:</strong><br>
    <?= !empty($detail->tour_description) 
        ? nl2br(htmlspecialchars($detail->tour_description)) 
        : "<i>Chưa có mô tả</i>" ?>
  </p>

  <p><strong>Số ngày:</strong> 
      <?= $detail->number_of_days ?? $detail->tour_days ?> ngày
  </p>

  <p><strong>Số đêm:</strong> 
      <?= $detail->number_of_nights ?? $detail->tour_nights ?> đêm
  </p>

  <p><strong>Ngày khách muốn đi:</strong> 
      <?= htmlspecialchars($detail->date) ?>
  </p>

  <p><strong>Ghi chú của khách:</strong><br>
      <?= !empty($detail->note) ? nl2br(htmlspecialchars($detail->note)) : "<i>Không có</i>" ?>
  </p>

  <p><strong>Số lượng khách:</strong> <?= $detail->quantity ?></p>

  <p><strong>Số điện thoại khách:</strong> 0<?= htmlspecialchars($detail->phone) ?></p>

  <p><strong>Tên khách hàng:</strong> <?= htmlspecialchars($detail->customername) ?></p>


  <!-- Chưa có danh sách khách, vì model chưa join -->
  <h3>👥 Danh sách khách hàng</h3>




<div class="button-row">

    <!-- Nút quay lại bên trái -->
    <div class="left">
        <a href="?action=guide_pending_tour" class="back-btn">← Quay lại</a>
    </div>

    <!-- Hai nút hành động bên phải -->
    <form action="" method="post" id="confirmForm" class="right">
        <button class="btn btn-success custom-btn" type="submit" name="confirm">
            ✔ Xác nhận
        </button>

        <button class="btn btn-danger custom-btn" type="submit" name="cancel">
            ✖ Hủy
        </button>
    </form>

</div>


<script>
document.getElementById("confirmForm").addEventListener("submit", function(e) {
    let btn = document.activeElement;

    if (btn.name === "confirm") {
        if (!confirm("Bạn có chắc sẽ nhận lịch làm việc chứ?")) {
            e.preventDefault();
        }
    }

    if (btn.name === "cancel") {
        if (!confirm("Bạn có chắc muốn hủy không?")) {
            e.preventDefault();
        }
    }
});
</script>

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

/* Nhóm nút căn giữa */
.action-buttons {
    margin-top: 20px;
    display: flex;
    gap: 15px;
    justify-content: center;
}

/* Style nút đẹp hơn */
.custom-btn {
    padding: 10px 22px;
    font-size: 16px;
    border-radius: 8px;
    font-weight: 600;
    min-width: 120px;
    transition: 0.2s;
}

/* Hiệu ứng hover */
.custom-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

/* Bo góc & đổ bóng nhẹ */
.custom-btn:active {
    transform: translateY(0);
}
/* Hàng chứa 3 nút */
.button-row {
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Căn trái */
.left {
    flex: 1;
}

/* Căn phải */
.right {
    display: flex;
    gap: 12px;
}

/* Nút quay lại */
.back-btn {
    padding: 10px 20px;
    background: #6c757d;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}

.back-btn:hover {
    background: #5a6268;
    transform: translateX(-2px);
}

/* Nút hành động */
.custom-btn {
    padding: 10px 22px;
    font-size: 16px;
    border-radius: 8px;
    font-weight: 600;
    min-width: 120px;
    transition: 0.2s;
}

.custom-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

</style>
