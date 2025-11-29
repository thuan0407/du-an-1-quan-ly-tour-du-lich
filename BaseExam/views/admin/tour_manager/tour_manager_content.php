<?php require_once __DIR__ . '/../navbar.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tour</title>
</head>
<body>
<div class="content-wrapper">
    <h1>QUẢN LÝ TOUR</h1>
    
    <!-- Tìm kiếm tour -->
        <form action="index.php" method="get" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-3 " style="margin:0 100px">
            <input type="text" name="key_word" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
            <button type="submit" class="btn btn-primary" name="search_tour">Tìm</button>
            <input type="hidden" name="action" value="search_tour">
            <span style="color:red;"><?= $notification?></span>
        </form>

    <div class="d-flex">
        <!-- lọc theo loại tour -->
        <form action="index.php" method="get" class="d-flex align-items-center gap-2 mb-3" style="margin:0 100px">
            <label for="">Lọc theo loại tour</label>
            <select name="tour_type_name" class="form-control" onchange="this.form.submit()">
                <option value="">--Loc theo loại tour--</option>
                <?php foreach($list_tour_type as $list_tt): ?>
                    <option value="<?= $list_tt->id ?>" <?= ($selectedType == $list_tt->id) ? 'selected' : '' ?>>
                        <?= $list_tt->tour_type_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="action" value="tour_manager_content">
        </form>


        <!-- lọc theo giá -->
        <form action="index.php" method="get" class="d-flex align-items-center gap-2 mb-3" style="margin:0 100px">
            <label for="">Lọc theo Giá</label>
            <select name="price" class="form-control" onchange="this.form.submit()">
                <option value="">-- Chọn giá --</option>
                <option value="1" <?= (($_GET['price'] ?? '') == 1 ? 'selected' : '') ?>>Từ cao xuống thấp</option>
                <option value="2" <?= (($_GET['price'] ?? '') == 2 ? 'selected' : '') ?>>Từ thấp lên cao</option>
            </select>
            
            <input type="hidden" name="action" value="tour_manager_content">
        </form>



         <a href="?action=add_tour" class="btn btn-success" style="width:200px; height:45px;">++ Thêm</a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

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
        <?php foreach ($list as $tt): ?>
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
                    <a href="?action=tour_detail&id=<?= htmlspecialchars($tt->id) ?>" 
                    class="btn btn-warning">
                        Xem chi tiết
                    </a>

                    <?php if (!in_array($tt->id, $bookedTours)): ?>                         <!-- // in_array kiêm tra một giá trị có nằm trong mảng hay không -->
                        <a href="?action=delete_tour&id=<?= $tt->id ?>" 
                        class="btn btn-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa tour này?')">
                        Xóa
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled title="Tour đã có booking">
                            Không thể xóa
                        </button>
                    <?php endif; ?>

                    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
