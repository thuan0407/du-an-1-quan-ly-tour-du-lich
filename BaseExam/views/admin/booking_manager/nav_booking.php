<?php require_once __DIR__ . '/../navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content-wrapper ">
        <h1>QUẢN ĐẶT TOUR</h1>
        <div class="row">
            <a href="?action=booking_tour"         class="col btn btn-success">Đặt tour theo yêu cầu</a>
            <a href="?action=waiting_for_approval" class="col btn btn-danger">Tour chờ duyệt</a>
            <a href="?action=tour_is_active"       class="col btn btn-primary">Tour đang hoạt động</a>
            <a href="?action=tour_has_ended"       class="col btn btn-warning">Tour đã kết thúc</a>
            <a href="?action=tour_canceled"       class="col btn btn-dark">Tour đã hủy</a>

            
        </div>
</div>
    
</body>
</html>