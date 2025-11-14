<?php require_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content-wrapper">
        <h1>QUẢN LÝ NHÂN SỰ</h1>
        <table class="table">
            <thead>
                <th>STT</th>
                <th>Họ và tên</th>
                <th>eamil</th>
                <th>loại HDV</th>
                <th>Năm kinh nghiệm</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </thead>

            <tbody>
                <?php
                $i=1;
                foreach($list as $tt){
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$tt->name?></td>
                        <td><?=$tt->email?></td>
                        <td><?=$tt->type_guide?></td>
                        <td><?=$tt->years_experience?></td>
                        <td><?=$tt->img?></td>
                        <td>
                            <a href="#" class="btn btn-primary">Khóa / mở khóa</a>
                            <a href="?action=tour_guide_detail&id=<?=$tt->id?>" class="btn btn-warning">Xem chi tiết</a>
                            <a href="#" class="btn btn-secondary">Xem lịch làm việc</a>
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