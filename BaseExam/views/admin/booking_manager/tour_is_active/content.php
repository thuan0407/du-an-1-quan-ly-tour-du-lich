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
        <h2>Tour đang hoạt động</h2>
        <!-- Tìm kiếm tour -->
        <!-- <form action="index.php" method="get" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-3 " style="margin:0 100px">
            <input type="text" name="key_word" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
            <button type="submit" class="btn btn-primary" name="search_booking_tour">Tìm</button>
            <input type="hidden" name="action" value="search_booking_tour">
            <span style="color:red;"><?= $notification?></span>
        </form> -->

        <table class="table talbe:hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên tour</th>
                    <th>Giá</th>
                    <th>Khách hàng</th>
                    <th>SDT khách hàng</th>
                    <th>Thanh toán</th>
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
                            <td><?=number_format($tt->total_amount,0,'','.')?> VND</td>
                            <td><?=$tt->customername?></td>
                            <td>0<?=$tt->phone?></td>
                            <td>
                                <?php
                                if($tt->pay_status ==1):?>
                                    <p style="color:red;">Đã đặt cọc</p>
                                <?php else:?>
                                    <p style="color:green;">Đã thanh toán</p>
                                <?php endif;?>
                            </td>
                            <td>
                                <a href="?action=tour_is_active_detail&id=<?=$tt->id?>" class="btn btn-warning">Xem chi tiết</a>
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