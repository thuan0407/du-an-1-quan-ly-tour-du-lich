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
                                <img src="<?= BASE_URL . $img ?>" width="150">
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

            </div>

             <!-- lịch trình khởi hành chi tiết từng ngày -->
            <div>   
                <div class="mb-3" id="schedule-item">
                <h4>Lịch khởi hành chi tiết</h4>
                <?php foreach($schedule_details as $index => $s_d): ?>
                    <div class="d-flex mb-2 align-items-start schedule-row">    
                        <span class="me-2 fw-bold">Ngày <?= $index + 1 ?>:</span>
                        <textarea name="departure_schedule_details_content[]" class="form-control me-2" placeholder="Nội dung..."><?= htmlspecialchars($s_d['content'] ?? '') ?></textarea>       
                        <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-success mt-2" onclick="add_schedule()">Thêm ngày</button> <br><br>


            <div>
                <h4>Danh sách khách hàng</h4>
                    <div id="customer-inputs">
                        <div class="customer-row d-flex gap-3 align-items-end mb-3">
                            <div class="col">
                                <label for="">Tên khách hàng</label>
                                <input type="text" name="name_customer[]" class="form-control" required>
                            </div>

                            <div class="col">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone_customer[]" class="form-control" required>
                            </div>

                            <div class="col">
                                <label for="">Giới tính</label>
                                <select name="sex[]" class="form-control" required>
                                    <option value="">---Chọn giới tính---</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                    <option value="3">Khác</option>
                                </select>
                            </div>
                            
                            <div class="col-auto delete-col-template" style="width: 50px;">
                                </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mb-3" onclick="addCustomer()"> + Thêm khách hàng</button>
            </div><br>


            </div>

            <div class="d-flex">
                <a href="?action=booking_tour" class="btn btn-danger form-control" >Quay lại</a>
                <button type="submit" name="order_tour" class="btn btn-primary form-control" >Đặt tour</button>
            </div>

    </form>

</div>

</body>
</html>
<script>
    //lịch khởi hành chi tiết
function add_schedule() {
    let container = document.getElementById('schedule-item');
    // Số ngày hiện tại
    let dayCount = container.querySelectorAll('div.schedule-row').length + 1;

    let div = document.createElement('div');
    div.classList.add('d-flex', 'mb-2', 'align-items-start', 'schedule-row');
    div.innerHTML = `
        <span class="me-2 fw-bold">Ngày ${dayCount}:</span>
        <textarea name="departure_schedule_details_content[]" class="form-control me-2" placeholder="Nội dung..."></textarea>
        <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>
    `;
    container.appendChild(div);
}

function removeItem(btn) {
    let row = btn.closest('.schedule-row');
    if (row) row.remove();
}
</script>
<script>
    // Hàm tạo nút Xóa
    function createDeleteButton() {
        let deleteBtn = document.createElement("button");
        deleteBtn.setAttribute("type", "button");
        deleteBtn.setAttribute("class", "btn btn-danger");
        deleteBtn.setAttribute("onclick", "removeCustomer(this)");
        deleteBtn.textContent = "Xóa";
        return deleteBtn;
    }

    // ⭐ HÀM CHÍNH: THÊM KHÁCH HÀNG ⭐
    function addCustomer() {
        let container = document.getElementById("customer-inputs");
        let template = container.querySelector(".customer-row");
        
        // 1. Sao chép toàn bộ dòng đầu tiên
        let clone = template.cloneNode(true);
        
        // 2. Reset giá trị input và select
        clone.querySelector('input[name="name_customer[]"]').value = '';
        clone.querySelector('input[name="phone_customer[]"]').value = '';
        clone.querySelector('select[name="sex[]"]').selectedIndex = 0;

        // 3. Xóa nội dung div template (đảm bảo không còn nút cũ/text cũ)
        let deleteCol = clone.querySelector('.delete-col-template');
        deleteCol.innerHTML = '';
        
        // 4. Thêm nút Xóa vào dòng mới
        deleteCol.appendChild(createDeleteButton());
        
        // 5. Thêm dòng mới vào container
        container.appendChild(clone);
    }
    
    // ⭐ HÀM XÓA KHÁCH HÀNG ⭐
    function removeCustomer(btn) {
        let row = btn.closest(".customer-row");
        if (row) {
            let container = document.getElementById("customer-inputs");
            
            // Đảm bảo không xóa dòng cuối cùng/duy nhất
            if (container.children.length > 1) {
                row.remove();
            } else {
                alert("Phải có ít nhất 1 khách hàng!");
            }
        }
    }
</script>