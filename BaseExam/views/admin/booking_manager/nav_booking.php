<?php require_once __DIR__ . '/../navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đặt tour</title>

    <style>
        .content-wrapper {
            padding: 20px;
        }

        /* Container của menu */
        .booking-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Hiệu ứng nút menu */
        .booking-nav a {
            transition: 0.2s;
        }

        /* Khi hover */
        .booking-nav a:hover {
            transform: scale(1.05);
        }

        /* ⭐ Nút đang active ⭐ */
        .booking-nav a.active {
            transform: scale(1.15);
            font-weight: bold;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            border: 2px solid white !important;
        }
    </style>
</head>

<body>

<?php 
    // Lấy action hiện tại để tô sáng tab tương ứng
    $current = $_GET['action'] ?? '';
?>

<div class="content-wrapper">

    <h1>QUẢN ĐẶT TOUR</h1>

    <div class="booking-nav">
        <a href="?action=booking_tour" 
           class="col btn btn-success <?= ($current == 'booking_tour') ? 'active' : '' ?>">
           Đặt tour theo yêu cầu
        </a>

        <a href="?action=tour_is_active" 
           class="col btn btn-primary <?= ($current == 'tour_is_active') ? 'active' : '' ?>">
           Tour đang hoạt động
        </a>

        <a href="?action=tour_has_ended" 
           class="col btn btn-warning <?= ($current == 'tour_has_ended') ? 'active' : '' ?>">
           Tour đã kết thúc
        </a>

        <a href="?action=tour_canceled" 
           class="col btn btn-dark <?= ($current == 'tour_canceled') ? 'active' : '' ?>">
           Tour đã hủy
        </a>
    </div>

</div>

</body>
</html>
