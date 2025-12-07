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
   

        <div class="container">
            <?php foreach($list_tour as $tt): ?>
                <div class="item">
                        <?php 
                            $firstImage = !empty($tt->images) ? $tt->images[0] : null;               //hiển thị một ảnh đầu tiên
                            ?>

                            <?php if ($firstImage): ?>
                                <img src="<?= BASE_URL . $firstImage ?>" width="100">
                            <?php else: ?>
                                <img src="/uploads/default.jpg" width="100">
                            <?php endif; ?> <br>

                    <label for="" class="title"><?= htmlspecialchars($tt->name) ?></label><br>
                    <h4><?= number_format($tt->price,0,'','.') ?> VND</h4>
                    <label for="">Số chỗ: <?= htmlspecialchars($tt->scope) ?></label><br>
                    <?= htmlspecialchars($tt->date) ?><br>

                        <a href="?action=booking_individual_tours_detail&id=<?=$tt->id?>" class="btn btn-warning">Xem chi tiết tour</a>
                </div>
                    
            <?php endforeach; ?>
</div>
    
</body>
</html>
<style>
    /* --- CSS TÙY CHỈNH BẮT ĐẦU --- */

    /* Container chính */
    .container {
        display: flex;
        flex-wrap: wrap; 
        justify-content: space-around; 
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05); 
    }
    
    /* Các khối nội dung bên trong */
    .item {
        /* ⭐ ĐÃ THÊM: Căn giữa nội dung văn bản ⭐ */
        text-align: center; 
        /* ------------------------------------- */

        border: 1px solid #e0e0e0;
        padding: 15px;
        width: 22%; 
        min-width: 250px; 
        margin: 15px; 
        border-radius: 8px; 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Tiêu đề hoặc nội dung chính trong item */
    .item h4 {
        color: #ff006fff;
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 1.1em;
    }

    /* Văn bản trong item */
    .item p {
        color: #555;
        font-size: 0.95em;
        line-height: 1.4;
    }
    .title{
        font-size:20px;
        font-weight:bold;
    }
    
    /* Lưu ý: Nếu item có ảnh (<img>) thì nó sẽ tự động căn giữa */

    /* ⭐ HIỆU ỨNG HOVER ⭐ */
    .item:hover {
        transform: translateY(-5px); 
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15); 
        border-color: #007bff; 
        background-color: #f9f9ff; 
        cursor: pointer; 
    }

    /* Responsive: Trên màn hình nhỏ hơn */
    @media (max-width: 1200px) {
        .item {
            width: 30%; 
        }
    }

    @media (max-width: 800px) {
        .item {
            width: 45%; 
        }
    }

    @media (max-width: 550px) {
        .item {
            width: 90%; 
            margin: 15px auto;
        }
    }

    /* --- CSS TÙY CHỈNH KẾT THÚC --- */
</style>