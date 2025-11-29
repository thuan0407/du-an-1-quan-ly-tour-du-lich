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

        <!-- Thông báo -->
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

       <form action="" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-3 " style="margin:0 100px">

       <div class="row">
        <div class="col">
                    <h3>Tour: <?=$tour->name?></h3>

                    <div style="margin:20px;">
                        <?php if (!empty($tour_img)): ?>
                            <?php foreach($tour_img as $img): ?>
                                <img src="<?= BASE_URL . $img ?>" width="200">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <img src="/uploads/default.jpg" width="100">
                        <?php endif; ?>
                    </div>

                    <label for="">Loại tour: <?=$tour_type->tour_type_name?></label> <br>

                    <label for="">Khu vực: 
                        <?= $tour->type_tour == 1 ? "Nội địa" : "Ngoại địa" ?>
                    </label>

                    <div class="d-flex">
                        <label for="">Số chỗ:</label> 
                        <input type="number" value="<?=$tour->scope?>" name="quantity" class="form-control" required><br>

                        <label for="">Số ngày:</label> 
                        <input type="number" value="<?=$tour->number_of_days?>" name="number_of_days" class="form-control" required><br>

                        <label for="">Số đêm:</label> 
                        <input type="number" value="<?=$tour->number_of_nights?>" name="number_of_nights" class="form-control" required><br>
                    </div>

                    <label for="">Giá tour:</label> 
                    <input type="number" value="<?=$tour->price?>" name="total_amount" class="form-control" required> vnđ<br>

                    <label for="">Địa điểm:
                        <?php
                        foreach($address as $addr){
                            echo  htmlspecialchars($addr);
                        }
                    ?>
                    </label> <br>
                    

                    <label for="">Dịch vụ:
                        <?php
                            if(!empty($tour_supplier)){
                                foreach($tour_supplier as $ts){
                                    echo htmlspecialchars($ts);
                                }
                            }
                    ?>  
                    </label> <br>


                    <label for="">Mô tả: <?=$tour->describe?></label> <br>
                    <label for="">Ngày tạo: <?=$tour->date?></label> <br>

            </div>

    
            <div class="col">
                <h4>Khách hàng</h4>
                <div>
                    <label for="">Họ tên khách đặt:</label>
                    <input type="text" name="customername" class="form-control" required>

                    <label for="">Số điện thoại:</label>
                    <input type="text" name="phone" class="form-control" required>
                    
                    <label for="">File danh sách:</label>
                    <input type="file" name="list_customer" class="form-control" required>

                    <label for="">Ghi chú:</label>
                    <input type="text" name="note_customer" class="form-control" placeholder="Có thể bỏ trống"><br>
                    
                </div>

                <h4>Yêu cầu đặc biệt</h4>
                <div>
                    <input type="text" name="content_spceail" class="form-control" placeholder="Nhập yêu cầu đặc biệt..." required><br>
                </div>

                <h4>Hướng dẫn viên</h4>
                <div>
                    <select name="tour_guide_id" id="" class="form-control" required>
                        <?php
                        foreach($list_guide as $l_g):?>
                        <option value="<?=$l_g->id?>" <?= ($tour->type_tour == $l_g->type_guide&& $l_g->status ==1 ? 'selected': '') ?>> <?=$l_g->name?> </option>
                        <?php endforeach; ?>
                    </select><br>
                </div>

                <h4>Hợp đồng</h4>
                <div>
                    <label for="">Tên hợp đồng</label>
                    <input type="text" name="name_contract" class="form-control" required>

                    <label for="">Giá trị hợp đồng</label>
                    <input type="number" name="value_contract" class="form-control" placeholder="VNĐ" required>

                    <label for="">File hợp đồng</label>
                    <input type="file" name="content_contract" class="form-control" required>

                    
                </div>


        </div>

            <div class="col">
                <h4>lịch khởi hành</h4>
                <div>      
                    <label for="">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control" required>

                    <label for="">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control" required>

                    <label for="">Địa điểm xuất phát</label>
                    <input type="text" name="start_location" class="form-control" required>

                    <label for="">Địa điểm kết thúc</label>
                    <input type="text" name="end_location" class="form-control" required>

                    <label for="">Ghi chú</label>
                    <input type="text" name="departure_schedule_note" class="form-control" placeholder="Có thể bỏ trống"><br>
                </div>

                <h4>Chi tiết mỗi ngày LKH</h4>
                <div>
                    <div id="plan">
                        <div class="detail_plan d-flex gap-2 mt-2">
                            <input type="date" name="details_every_day[]" class="form-control" required>
                            <input type="text" placeholder="Nội dung....." class="form-control" name="detailed_content_every_day[]" required>
                            <button type="button" class="btn btn-danger" onclick="removePlan(this)">Xóa</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success mt-2" onclick="addPlan()">Thêm</button>
                </div>

                <h4>Thanh toán</h4>
                <div>
                    <label for="">Hình thức thanh toán</label>
                    <select name="payment_method" id="" class="form-control" required>
                        <option value="1">Chuyển khoản</option>
                        <option value="2">Tiền mặt</option>
                    </select>

                    <label for="">Số tiền</label>
                    <input type="number" name="amount_money" class="form-control" placeholder="Số tiền khách trả trước..." required>

                    <label for="">Ghi chú</label>
                    <input type="text" name="pay_note" class="form-control" placeholder="Có thể bỏ trống" > <br>
                </div>

                <div>
                    <a href="?action=booking_tour" class="btn btn-danger">Quay lại</a>
                    <button type="submit" name="order_tour" class="btn btn-primary">Đặt tour</button>
                </div>

            </div>
            

    </form>

</div>
         

<script>
function addPlan() {
    let plan = document.getElementById("plan");
    
    // clone bản đầu tiên
    let item = document.querySelector(".detail_plan").cloneNode(true);

    // reset tất cả input trong dòng mới
    item.querySelectorAll("input").forEach(input => input.value = "");

    plan.appendChild(item);
}

function removePlan(btn) {
    let item = btn.parentElement;

    // Không cho xóa nếu chỉ còn 1 dòng
    if (document.querySelectorAll(".detail_plan").length === 1) {
        alert("Phải có ít nhất 1 ngày hoạt động!");
        return;
    }

    item.remove();
}
</script>

</body>
</html>