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
        <h2>Đặt tour theo yêu cầu</h2>
        <!-- Tìm kiếm tour -->
        <form action="index.php" method="get" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-3 " style="margin:0 100px">
            <input type="text" name="key_word" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
            <button type="submit" class="btn btn-primary" name="search_booking_tour">Tìm</button>
            <input type="hidden" name="action" value="search_booking_tour">
            <span style="color:red;"><?= $notification?></span>
        </form>
    <table class="table">
        <thead>
        <tr>
            <th>Ảnh</th>
            <th>Tên tour</th>
            <th>Giá</th>
            <th>Số chỗ</th>
            <th>Ngày tạo</th>
            <th>Trạn thái</th>
            <th>Hành động</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach($list_tour as $tt): ?>
            <tr>
                <td>
                    <?php 
                        $firstImage = !empty($tt->images) ? $tt->images[0] : null;               //hiển thị một ảnh đầu tiên
                        ?>

                        <?php if ($firstImage): ?>
                            <img src="<?= BASE_URL . $firstImage ?>" width="100">
                        <?php else: ?>
                            <img src="/uploads/default.jpg" width="100">
                        <?php endif; ?>

                    <!-- <?php if (!empty($tt->images)): ?>                                      hiển thị toàn bộ ảnh
                        <?php foreach ($tt->images as $img): ?>
                            <img src="<?= BASE_URL . $img ?>" width="100" style="margin-right:5px;">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <img src="/uploads/default.jpg" width="100">
                    <?php endif; ?> -->
                </td>

                <td><?= htmlspecialchars($tt->name) ?></td>
                <td><?= number_format($tt->price,0,'','.') ?> VND</td>
                <td><?= htmlspecialchars($tt->scope) ?></td>
                <td><?= htmlspecialchars($tt->date) ?></td>
                <td>
                    <?php
                    if($tt->status ==1):?>
                        <a href="#" class="btn btn-success">Hoạt động</a>
                    <?php else:
                            ?>
                        <a href="#" class="btn btn-danger">Đã khóa</a>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="?action=booking_individual_tours_detail&id=<?=$tt->id?>" class="btn btn-warning">Xem chi tiết tour</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
    
</body>
</html>