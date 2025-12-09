<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php';
$success = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $success = "Ân thành công!";
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
        <h2>Tour đã hủy</h2>

        <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <table class="table talbe:hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên tour</th>
                    <th>Giá</th>
                    <th>Thanh toán</th>
                    <th>Khách hàng</th>
                    <th>SDT khách hàng</th>
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
                            <td style="color:blue;"><?=number_format($tt->total_amount,0,'','.')?> VND</td>
                            <td style="color:red;"><?=number_format($tt->amount_money,0,'','.')?> VND</td>
                            <td><?=$tt->customername?></td>
                            <td>0<?=$tt->phone?></td>
                            <td>
                                <a href="?action=hidden&id=<?=$tt->id?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc là muốn ẩn không?')">Ẩn</a>
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