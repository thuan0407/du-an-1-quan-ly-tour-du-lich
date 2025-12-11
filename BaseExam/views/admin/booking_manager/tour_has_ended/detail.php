<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết kết thúc tour</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        h4 {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            flex: 1 1 calc(50% - 20px); /* 2 card trên một hàng */
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        /* Màu cho số tiền */
        .amount {
            color: red;
            font-weight: bold;
        }

        /* Màu trạng thái */
        .status-red {
            color: red;
            font-weight: bold;
        }
        .status-green {
            color: green;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%; /* xếp 1 cột khi màn hình nhỏ */
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <h2>Trang chi tiết kết thúc tour</h2>

        <div class="card-container">
            <!-- Thông tin lịch khởi hành -->
            <div class="card">
                <h4>Thông tin lịch khởi hành</h4>
                <label>Ngày đi: <?=$departure_schedule->start_date?></label>
                <label>Ngày về: <?=$departure_schedule->end_date?></label>
                <label>Địa điểm đón khách: <?=$departure_schedule->start_location?></label>
                <label>Địa điểm trả khách: <?=$departure_schedule->end_location?></label>
                <label>Hướng dẫn viên: <?=$tour_guide->name?></label>
            </div>

            <!-- Thông tin thanh toán -->
            <div class="card">
                <h4>Thông tin thanh toán</h4>
                <h5 style="color:red;">Tổng thu: <?= number_format(round($paid), 0, '', '.') ?> VND</h5>
                <table class="table table-hover">
                    <tr>
                        <th>Ngày thanh toán</th>
                        <th>Số tiền thanh toán</th>
                        <th>Hình thức</th>
                        <th>Trạng thái</th>
                    </tr>
                    <?php foreach($pay as $p): ?>
                    <tr>
                        <td><?=$p->date?></td>
                        <td class="amount"><?=number_format($p->amount_money)?> VND</td>
                        <td><?= $p->payment_method == 1 ? 'Online' : 'Tiền mặt' ?></td>
                        <td>
                            <?php if($p->status ==1):?>
                                <p>Chưa đủ</p>
                            <?php else :?>
                                <p>Đã hoàn thành</p>
                            <?php endif;?>
                           
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </table>
            </div>

            <!-- Danh sách khách hàng -->
            <div class="card">
                <h4>Danh sách khách hàng</h4>
                <table class="table table-hover">
                    <tr>
                        <th>STT</th>
                        <th>Tên khách</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                    </tr>
                    <?php $index = 1; foreach($customer_list as $ct): ?>
                    <tr>
                        <td><?=$index++?></td>
                        <td><?=$ct['name']?></td>
                        <td><?=$ct['phone']?></td>
                        <td><?= $ct['sex'] == 1 ? 'Nam' : 'Nữ' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- Yêu cầu đặc biệt -->
            <div class="card">
                <h4>Yêu cầu đặc biệt</h4>
                <table class="table table-hover">
                    <tr>
                        <th>STT</th>
                        <th>Ngày</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                    </tr>
                    <?php $index=1; foreach($special_request as $sp): ?>
                    <tr>
                        <td><?=$index++?></td>
                        <td><?=$sp->date?></td>
                        <td><?=$sp->content?></td>
                        <td class="<?= $sp->status == 2 ? 'status-red' : 'status-green' ?>">
                            <?= $sp->status == 2 ? 'Chưa hoàn thành' : 'Đã hoàn thành' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- Nhật ký tour -->
            <div class="card">
                <h4>Nhật ký tour</h4>
                <table class="table table-hover">
                    <tr>
                        <th>STT</th>
                        <th>Ngày</th>
                        <th>Đánh giá NCC</th>
                        <th>Ghi chú</th>
                        <th>Ảnh</th>
                    </tr>
                    <?php $index=1; foreach($diary_list as $dr): ?>
                    <tr>
                        <td><?=$index++?></td>
                        <td><?=$dr->date?></td>
                        <td><?=$dr->service_provider_evaluation?></td>
                        <td><?=$dr->note?></td>
                        <td>
                            <?php if($dr->img): ?>
                                <img src="<?=BASE_ASSETS_UPLOADS .$dr->img?>" alt="ảnh" width="100">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- Chi tiết lịch trình -->
            <div class="card">
                <h4>Chi tiết lịch trình</h4>
                <table class="table table-hover">
                    <tr>
                        <th>Ngày</th>
                        <th>Nội dung</th>
                    </tr>
                    <?php $index=1; foreach($departurescheduledetails_list as $dl): ?>
                    <tr>
                        <td>Ngày <?=$index++?></td>
                        <td><?=$dl->content?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <!-- điểm danh -->
    
            </div>
        </div>
    </div>
</body>
</html>
