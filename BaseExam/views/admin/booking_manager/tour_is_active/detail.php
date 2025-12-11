<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php';
$success = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $success = "Cập nhật Thành công!";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div class="content-wrapper ">
        <!-- Thông báo -->
        <?php if(!empty($success)):?>
            <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
            <?php endif;?>

        <h2>Chi tiết hoạt động tour <?=$tour->name?></h2>
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row" style="padding:0 20px;">
                <div class="col">
                    <h3 style="color:red;">Giá: <?=number_format($book_tour->total_amount,0,'','.')?>VND</h3>


                    <label for="">Loại tour: <?=$tour_type->tour_type_name?></label> <br>
                    <label for="">Khu vực: <?=$tour->type_tour ==1 ?"Nội địa":"Ngoại địa"?></label><br><br>

                    <h4>Hướng dẫn viên</h4>
                    <?php if(!empty($tour_guide)) :?>
                        <label for="">Hướng dẫn viên: <?=$tour_guide->name?></label><br>
                        <label for="">SDT HDV: 0<?=$tour_guide->phone_number?></label><br><br>
                    <?php endif;?>
           
                     <!-- Nếu số chỗ nhỏ hơn số chỗ tối thiểu thì sẽ khôgn đc chọn hướng dẫn viên -->

                    <?php if($book_tour->quantity >= $tour->minimum_scope): ?> 
                        <p class="text-success">Số lượng khách đã đủ, có thể cập nhật HDV</p>

                    <label for="">Cập nhật HDV cho tour</label>
                    <div class="d-flex">
                        <select name="id_tour_guide" id="" class="form-control" style="width:350px;">
                            <?php foreach($list_guide as $li) :?>
                                <option value="<?= $li->id ?>"><?= htmlspecialchars($li->name) ?></option>
                            <?php endforeach ;?>
                        </select>
                        <button class="btn btn-primary" type="submit" name="update_tour_guide">Cập nhật</button>
                    </div>                              
                    <?php else: ?>
                        <p class="text-danger">Chưa thể cập nhật hướng dẫn viên vì số lượng khách chưa đủ</p>
                    <?php endif; ?>
                    
                    <br>
                </div>

                <div class="col">
                    <h4>Khách hàng</h4> <label for="">
                        <a href="?action=comtomer_list&id=<?=$book_tour->id?>">>>>Danh sách hàng</a>
                    
                    <label for="">Khách hàng: <?=$book_tour->customername?></label><br>
                    <label for="">SDT khách hàng: 0<?=$book_tour->phone?></label> <br> <br>

                    <h4>Yêu cầu đặc biệt</h4>
                    <table class="table table-hover">
                        <tr>
                            <th>STT</th>
                            <th>Ngày</th>
                            <th>Nội dung</th>
                        </tr>
                        <?php $i=0;
                        foreach($list_special_request as $sp_r){ $i++?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$sp_r->date?></td>
                            <td><?=$sp_r->content?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                  
                    
                </div>

              </div><br>
               <div style="padding:0 50px;">
                    <h4>Địa điểm</h4>
                    <div class="d-flex justify-content-between" style="gap: 20px; margin:0 200px;">
                        <div>
                            <label>Điểm bắt đầu: <?=$departure_schedule->start_location?></label><br>
                            <label>Điểm kết thúc: <?=$departure_schedule->end_location?></label>
                        </div>
                        <div>
                            <label>Ngày khởi hành: <?=$departure_schedule->start_date?></label><br>
                            <label>Ngày kết thúc: <?=$departure_schedule->end_date?></label>
                        </div>
                    </div>


                    <h4>Chi tiết lịch trình</h4>
                    <table class="table table-hover">
                        <tr>
                            <th>Ngày</th>
                            <th>Nội dung</th>
                        </tr>
                        <?php $i=0;
                        foreach($list_departure_schedule_details as $ds){$i++; ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$ds->content?></td>
                        </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div><br>

            
                <!-- Cập nhật hoàn thiện thanh toán của tour -->
                 <hr>
                    <input type="text" name="note_pay" class="form-control" placeholder="Ghi chú"> <br>
                
                <div class="d-flex">
                    <select name="payment_method" id="" class="form-control col">
                        <option value="1">Online</option>
                        <option value="2">Tiền mặt</option>
                    </select>
 
                    <input type="number" name="amount_money_pay" class="form-control col " placeholder="Nơi nhập tiền xử lý hủy hoặc kết thúc tour..">
                     
                </div>
                


           
                    <div class="flex-fill">
                        <?php if($departure_schedule->status == 1): ?>
                            <button class="btn btn-danger w-100" type="submit" name="cancel" onclick="return confirm('Bạn có chắc là muốn xóa chuyến tour này không?')">
                                Hủy tour
                            </button>
                        <?php else: ?>
                            <button class="btn btn-success w-100" type="submit">
                                Không thể hủy
                            </button>
                        <?php endif; ?>
                    </div>

 
              
        </form>

</div>
    
</body>
</html> 
    <style>
    /* --- CSS CƠ SỞ VÀ KHUNG CHUNG --- */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f7f9fc; /* Nền sáng */
        color: #333;
    }

    /* Container chính chứa nội dung tour */
    .content-wrapper {
        padding: 20px 0;
        margin: 0 auto;
        background-color: #ffffff; /* Nền trắng cho toàn bộ nội dung chính */
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-radius: 8px;
    }

    /* Tiêu đề tour */
    h2 {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 30px;
        font-size: 1.8rem;
        padding-left: 50px; 
        padding-right: 50px;
    }

    h3, h4 {
        color: #343a40;
        margin-top: 20px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    label {
        font-weight: 500;
        color: #555;
        display: block; 
        margin-bottom: 5px;
    }

    /* --- PHẦN INPUT VÀ CĂN CHỈNH FORM --- */
    .form-control, select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        transition: border-color 0.3s;
    }

    .d-flex {
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    /* Điều chỉnh input Đã cọc */
    .d-flex input[name="amount_money_pay"] {
        width: 200px !important; 
    }
    .d-flex label {
        flex-shrink: 0;
    }
    
    /* Căn chỉnh khối chọn HDV mới */
    .col > div {
        margin-top: 15px;
    }
    .col > div select {
        width: 350px;
    }

    /* --- KHỐI THÔNG TIN CHIA CỘT (Giá/HDV và Khách hàng/Yêu cầu) --- */
    .row {
        padding: 0 50px; /* Căn chỉnh với Timeline */
    }
    .row > .col {
        padding: 20px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background-color: #f8f9fa; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .row > .col:first-child {
        margin-right: 20px;
    }


    /* --- PHẦN ĐỊA ĐIỂM & LỊCH TRÌNH --- */
    .content-wrapper > form > div:last-child {
        padding: 20px 50px;
        margin-top: 20px;
    }

    /* --- BẢNG (TABLE) --- */
    .table {
        margin-top: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden; 
    }
    .table th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
    }

    /* --- NÚT HÀNH ĐỘNG HỦY/KHÔNG HỦY --- */
    .form-control.btn {
        margin-top: 30px;
        font-weight: 600;
        padding: 12px;
        border-radius: 8px;
        width: 100%;
    }
    
    /* --- TIMELINE (Giữ nguyên cấu trúc nhưng loại bỏ hiệu ứng hover/active) --- */
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
        background: #ddd; 
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
        background: #ccc; /* Màu mặc định cho tất cả các bước */
        border-radius: 50%;
        margin: 0 auto;
        transition: 0.3s;
    }

    .timeline-step.active .circle {
        background: #28a745; /* Vẫn giữ lại nếu bạn muốn dùng logic PHP cũ */
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
    /* --- HẾT TIMELINE --- */

    /* Responsive cơ bản */
    @media (max-width: 992px) {
        .row {
            padding: 0 20px;
        }
        .row > .col {
            margin-right: 0;
            margin-bottom: 20px;
        }
        .content-wrapper > form > div:last-child {
            padding: 20px;
        }
        .d-flex input[name="amount_money_pay"] {
            width: 100% !important; 
        }
        .col > div select {
            width: 100% !important;
        }
    }
</style>
