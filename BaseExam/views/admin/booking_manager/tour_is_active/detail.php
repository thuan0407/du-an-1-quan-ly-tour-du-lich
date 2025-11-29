<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 40px 0;
        }

        .timeline::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 4px;
            background: #ddd;     /* màu đường */
            z-index: 1;
        }

        .timeline-step {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .timeline-step .circle {
            width: 25px;
            height: 25px;
            background: #ccc;
            border-radius: 50%;
            margin: 0 auto;
            transition: 0.3s;
        }

        .timeline-step.active .circle {
            background: #28a745; /* màu xanh sáng */
        }

        .timeline-step .label {
            margin-top: 8px;
            font-size: 14px;
            color: #555;
        }

        .timeline-step.active .label {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="content-wrapper ">
        <h2>Chi tiết hoạt động tour <?=$tour->name?></h2>
        <div class="row">
            <div style="width:90%; margin-left:50px;">
                <div class="timeline">
                    <?php foreach ($arr_merged as $index => $label): ?>
                        <div class="timeline-step <?= ($index + 1) <= $step ? 'active' : '' ?>">
                            <div class="circle"></div>
                            <div class="label"><?= $label ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div></div>
            <h3><label for="" style="color:red;">Giá: <?=number_format($book_tour->total_amount,0,'','.')?>VND</label></h3>

            <label for="">Loại tour:</label> <br>

            <label for="">Khu vực: <?=$tour->type_tour ==1 ?"Nội địa":"Ngoại địa"?></label><br><br>


            <h4>Khách hàng</h4>
            <label for="">Khách hàng: <?=$book_tour->customername?></label><br>
            <label for="">SDT khách hàng: 0<?=$book_tour->phone?></label> <br> <br>

            <h4>Hướng dẫn viên</h4>
            <label for="">Hướng dẫn viên: <?=$tour_guide->name?></label><br>
            <label for="">SDT HDV: 0<?=$tour_guide->phone_number?></label><br>

            <button class="btn btn-danger">Hủy tour</button>

        </div>

</div>
    
</body>
</html> 