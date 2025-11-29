<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>
<?php
$success = '';
$error = '';

// Lấy thông báo từ GET param "msg"
if(isset($_GET['msg'])){
    if($_GET['msg'] == 'success'){
        $success = "Xóa book tour thành công!";
    } elseif($_GET['msg'] == 'error'){
        $error = "Xóa tour thất bại hoặc book tour không tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content-wrapper ">
        <!-- thông báo -->
        <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <h2>Tour chờ duyệt</h2>
        <table class="table talbe:hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên tour</th>
                    <th>Giá</th>
                    <th>Khách hàng</th>
                    <th>SDT khách hàng</th>
                    <th>Ngày đăng ký tour</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $i=0;
                    foreach($list_book_tour as $tt){
                        $i++;
                        ?>
                        <tr>
                            <td><?=$i?></td>
                            <td>                 
                                    <img src="<?= BASE_URL . $tt->images[0] ?>" width="100">    <!-- lấy ảnh đầu tiên -->
                            </td>
                            <td><?=$tt->tour_name?></td>
                            <td><?=number_format($tt->total_amount,0,'','.') ?> VND</td>
                            <td><?=$tt->customername?></td>
                            <td>0<?=$tt->phone?></td>
                            <td><?=$tt->date?></td>
                            <td>
                                <a href="?action=waiting_for_approval_detail&id=<?=$tt->id?>" class="btn btn-warning">Xem chi tiết</a>
                                <a href="?action=waiting_for_approval_delete&id=<?=$tt->id?>" class="btn btn-danger" onclick="return confirm('bạn có chắc là muốn xóa tour này không?')">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                
            </tbody>
        </table>

</div>
    
</body>
</html>