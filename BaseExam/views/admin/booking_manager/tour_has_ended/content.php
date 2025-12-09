<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content-wrapper ">
        <h2>Tour đã kết thúc</h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên tour</th>
                    <th>Giá tour</th>
                    <th>Khách hàng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($list_book_tour as $list):?>
                    <tr>
                        <td><?=$i++?></td>
                        <td>
                             <?php 
                            $firstImage = !empty($list->images) ? $list->images[0] : null;               //hiển thị một ảnh đầu tiên
                            ?>

                            <?php if ($firstImage): ?>
                                <img src="<?= BASE_URL . $firstImage ?>" width="100">
                            <?php else: ?>
                                <img src="/uploads/default.jpg" width="100">
                            <?php endif; ?>
                        </td>
                        <td><?=$list->tour_name?></td>
                        <td style="color:red;"><?=number_format($list->total_amount,0,'','.')?> VND</td>
                        <td><?=$list->customername?></td>
                   
                        <td>
                            <a href="?action=detail_tour_has_endes&id=<?=$list->id?>" class="btn btn-warning">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
</div>
    
</body>
</html>