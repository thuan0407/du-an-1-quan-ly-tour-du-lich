<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>
<?php
$success = "";
$error = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $success = "update Thành công!";
    }
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
    <div class="content-wrapper ">
          <!-- Thông báo -->
        <?php if(!empty($success)):?>
            <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
            <?php endif;?>

   
    <h2 class="mb-4">Danh sách khách hàng</h2>

     <h3>Số chỗ tối đa: <?=$book_tour->quantity?></h3>

    <form id="customerForm" method="post" action="">
        <?php $index = 1; foreach($customer_list as $cu_l): ?>
        <div class="row align-items-center mb-2 customer-row">

            <!-- lấy id của khách hàng -->
             <input type="hidden" name="customer_id[]" value="<?= $cu_l['id'] ?>">
            
            <div class="col-1 fw-bold"><?=$index++?></div>

            <div class="col-3">
                <input type="text" name="name[]" value="<?=$cu_l['name']?>" class="form-control">
            </div>

            <div class="col-3">
                <input type="text" name="phone[]" value="0<?=$cu_l['phone']?>" class="form-control">
            </div>

            <div class="col-2">
                <select name="sex[]" class="form-select">
                    <option value="1" <?=$cu_l['sex']==1?'selected':''?>>Nam</option>
                    <option value="2" <?=$cu_l['sex']==2?'selected':''?>>Nữ</option>
                    <option value="0" <?=$cu_l['sex']!=1 && $cu_l['sex']!=2?'selected':''?>>Khác</option>
                </select>
            </div>

            <div class="col-3">
                <button type="button" class="btn btn-danger" onclick="removeCustomer(this)">Xóa</button>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="mt-4">
            <a href="?action=tour_is_active_detail&id=<?=$book_tour->id?>" class="btn btn-dark">Quay lại</a>
            <button type="submit" class="btn btn-primary" name="update" class="btn btn-primary">Cập nhật</button>
            <button type="button" class="btn btn-success" onclick="addCustomer()">+ Thêm khách</button>
        </div>
    </form>
</div>

<script>
function removeCustomer(btn) {
    if(confirm('Bạn có chắc muốn xóa khách này không?')) {
        const row = btn.closest('.customer-row');
        row.remove(); // Xóa khỏi DOM
    }
}

function addCustomer() {
    const form = document.getElementById('customerForm');
    const index = form.querySelectorAll('.customer-row').length + 1;
    const id = 'new_' + Date.now(); // id tạm cho khách mới
    const div = document.createElement('div');
    div.classList.add('row','align-items-center','mb-2','customer-row');
    div.setAttribute('data-id', id);
    div.innerHTML = `
        <input type="hidden" name="customer_id[]" value=""> 
        <div class="col-1 fw-bold">${index}</div>
        <div class="col-3"><input type="text" name="name[]" class="form-control"></div>
        <div class="col-3"><input type="text" name="phone[]" class="form-control"></div>
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
</script>

</body>
</html>
