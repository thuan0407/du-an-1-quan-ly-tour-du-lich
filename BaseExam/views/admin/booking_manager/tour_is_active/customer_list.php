<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>
<?php
$success = "";
if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
    $success = "Cập nhật thành công!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <form id="customerForm" method="post" action="">

    <!-- ================= THANH TOÁN ================= -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Thanh toán</h2>
        <h4 id="money_display" class="text-danger"></h4>
        <div>
            <label for="">Số tiền đã cọc</label>
            <input type="text" value="<?= number_format($paid,0,'','.')?> VND" class="form-control" readonly>
        </div>
        <div class="col-md-3">
            <label>Số chỗ hiện max:</label>
            <input type="number" class="form-control" value="<?= $tour->scope ?>" readonly>
        </div>
        <input type="hidden" id="money" name="total_money" value="">
    </div>

    <input type="hidden" id="price_tour" value="<?= $tour->price ?>">
    <input type="hidden" id="base_day_tour" value="<?= $tour->number_of_days ?>">
    <input type="hidden" id="day_now" value="<?= $book_tour->number_of_days ?>">
    <input type="hidden" id="old_quantity" value="<?= $book_tour->quantity ?>">

    <div class="mb-3 row g-3 align-items-center">

        <div class="col-md-3">
            <label>Số chỗ hiện tại:</label>
            <input type="number" class="form-control" id="quantity" name="quantity"
                   value="<?= $book_tour->quantity ?>" max="<?= $tour->scope ?>" min="1">
        </div>

        <div class="col-md-3">
            <label>Số tiền cần đặt cọc:</label>
            <input type="number" id="amount_money" class="form-control text-danger" name="amount_money">
        </div>

        <div class="col-md-3">
            <label>Trạng thái thanh toán</label>
            <select name="status_pay" class="form-control">
                <option value="1">Đặt cọc</option>
                <option value="2">Thanh toán hết</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Hình thức:</label>
            <select class="form-select" name="payment_method">
                <option value="1">Chuyển khoản</option>
                <option value="2">Tiền mặt</option>
            </select>
        </div>
    </div>

    <div>
        <input type="text" class="form-control mb-3" name="note_pay">
    </div>

    <!-- NÚT CẬP NHẬT THANH TOÁN -->
     <button type="submit" class="btn btn-success w-100" name="insert_payment">Thanh toán</button>
    <hr>

    <!-- ================= DANH SÁCH KHÁCH HÀNG ================= -->
    <h2>Danh sách khách hàng</h2>

    <?php $index = 1; foreach($customer_list as $cu_l): ?>
        <div class="row g-3 mb-2 align-items-center customer-row">

            <input type="hidden" name="customer_id[]" value="<?= $cu_l['id'] ?>">

            <div class="col-1 fw-bold"><?= $index++ ?></div>
            <div class="col-3">
                <input type="text" name="name[]" class="form-control" value="<?= $cu_l['name'] ?>">
            </div>
            <div class="col-3">
                <input type="text" name="phone[]" class="form-control" value="0<?= $cu_l['phone'] ?>">
            </div>
            <div class="col-2">
                <select name="sex[]" class="form-select">
                    <option value="1" <?= $cu_l['sex']==1?'selected':'' ?>>Nam</option>
                    <option value="2" <?= $cu_l['sex']==2?'selected':'' ?>>Nữ</option>
                    <option value="0" <?= $cu_l['sex']==0?'selected':'' ?>>Khác</option>
                </select>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-danger" onclick="removeCustomer(this)">Xóa</button>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="mt-4 d-flex gap-2">
        <a href="?action=tour_is_active_detail&id=<?= $book_tour->id ?>" class="btn btn-dark">Quay lại</a>

        <!-- NÚT UPDATE KHÁCH HÀNG -->
        <button type="submit" class="btn btn-primary" name="update">Cập nhật khách hàng</button>

        <button type="button" class="btn btn-success" onclick="addCustomer()">+ Thêm khách</button>
    </div><br><br>

</form>
</div>

<script>
// Sử dụng Function Declaration (cách khai báo truyền thống)
function money() {
    let price_tour = Number(document.getElementById("price_tour").value);
    let base_day_tour = Number(document.getElementById("base_day_tour").value);
    let day_now = Number(document.getElementById("day_now").value);
    let quantity = Number(document.getElementById("quantity").value);
    let old_quantity = Number(document.getElementById("old_quantity").value);   // số lượng người cũ

    if (!price_tour || !base_day_tour || !day_now || !quantity) {
        document.getElementById("money_display").innerText = '0 VND';
        document.getElementById("money").value = 0;
        return;
    }

    let money_day_person = price_tour / base_day_tour;  // giá của 1 người trên 1 ngày
    let total = money_day_person * day_now * quantity;  // giá tổng hiện tại

    document.getElementById("money_display").innerText = total.toLocaleString('vi-VN') + ' VND';
    document.getElementById("money").value = Math.round(total);   // tổng tiền hiển thị

    // tính tiền đặt cọc
    // tổng tiền bên booking trước đó = số chỗ * số ngày * số chỗ 
    let old_price = money_day_person * old_quantity * day_now ; // giá trước đó
    let deposit = (Math.round(total) - Math.round(old_price))*0.5 // tiền cần cọc
    document.getElementById("amount_money").value = deposit;

    // hàm làm tròn gần nhất "Math.round"

    // console.log("giá cũ: " + old_price + " Tiền đặt cọc cũ: " + deposit + "  giá hiện tại: " + total);

}

function removeCustomer(btn) {
    if(confirm('Bạn có chắc muốn xóa khách này không?')) {
        btn.closest('.customer-row').remove();
    }
}

function addCustomer() {
    const form = document.getElementById('customerForm');
    const index = form.querySelectorAll('.customer-row').length + 1;
    const div = document.createElement('div');
    div.classList.add('row','g-3','mb-2','align-items-center','customer-row');
    div.innerHTML = `
        <input type="hidden" name="customer_id[]" value="">
        <div class="col-1 fw-bold">${index}</div>
        <div class="col-3"><input type="text" name="name[]" class="form-control"></div>
        <div class="col-3"><input type="number" name="phone[]" class="form-control"></div>
        <div class="col-2">
            <select name="sex[]" class="form-select">
                <option value="1">Nam</option>
                <option value="2">Nữ</option>
                <option value="0">Khác</option>
            </select>
        </div>
        <div class="col-3">
            <button type="button" class="btn btn-danger" onclick="removeCustomer(this)">Xóa</button>
        </div>
    `;
    form.insertBefore(div, form.querySelector('.mt-4'));
}

// **PHẦN MỚI:** Gán các sự kiện sau khi tài liệu đã tải hoàn toàn (đảm bảo hàm tồn tại)
window.onload = function() {
    // 1. Gọi hàm money() lần đầu tiên khi tải trang
    money();
    
    // 2. Gắn sự kiện 'input' cho ô số lượng
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('input', money);
    }
};

</script>

</body>
</html>