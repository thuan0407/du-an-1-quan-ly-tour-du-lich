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
                    </label><br>

                    <!-- số chỗ tối thiểu -->
                    <div class="d-flex gap-3">
                        <label>Số chỗ tối thiểu: <?= $tour->minimum_scope ?></label>
                        <label>Số chỗ tối đa: <?= $tour->scope ?></label>
                    </div>
                    <input type="hidden" id="minimum_scope" value="<?= $tour->minimum_scope ?>">
                    <input type="hidden" id="max_scope" value="<?= $tour->scope ?>">


                    <div class="d-flex">
                        <label for="">Số chỗ:</label> 
                        <input type="number" id="scope" oninput="add_scope()" value="1" name="quantity" class="form-control" min="1" max="<?= $tour->scope ?>" required><br>

                        <label for="">Số ngày:</label> 
                        <input type="hidden" id="base_day" value="<?=$tour->number_of_days?>">
                        <input type="number" id="number_of_days" oninput="add_number_of_days()" value="<?=$tour->number_of_days?>" name="number_of_days" class="form-control" min ="1" required><br>

                        <label for="">Số đêm:</label> 
                        <input type="number" id="number_of_nights" value="<?=$tour->number_of_nights?>" name="number_of_nights" class="form-control" readonly><br>
                    </div>

                    <label for="">Giá tour:</label> 
                    <input type="hidden" id="base_price" value="<?=$tour->price?>">
                    <input type="number" id="price" value="<?=$tour->price?>" name="total_amount" class="form-control" required> vnđ<br>

                    <label for="">Địa điểm:
                        <?php
                        foreach($address as $addr){
                            echo  htmlspecialchars($addr);
                        }
                    ?>
                    </label> <br>
                


                    <label for="">Mô tả: <?=$tour->describe?></label> <br>
                    <label for="">Ngày tạo: <?=$tour->date?></label> <br><br>

            </div><br>

    
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
                        <?php foreach($list_guide as $l_g): ?>
                        <option value="<?=$l_g->id?>" <?= ($tour->type_tour == $l_g->type_guide && $l_g->status ==1 ? 'selected': '') ?>><?=$l_g->name?></option>
                        <?php endforeach; ?>
                    </select><br>
                </div>

                <!-- Hướng dẫn viên -->
                <div id="HDV"></div>

                <h4>Hợp đồng</h4>
                <div>
                    <label for="">Tên hợp đồng</label>
                    <input type="text" name="name_contract" class="form-control" required>

                    <label for="">Giá trị hợp đồng</label>
                    <input type="number" name="value_contract" class="form-control" min="1" placeholder="VNĐ" required>

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
                    <input type="number" id="amount_money" name="amount_money" class="form-control" placeholder="Số tiền khách trả trước... = 50% giá tổng" required>

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

            <div class="d-flex ">
                <div id="order_tour" class="flex-fill"></div>
            </div>

    </form>

</div>

</body>
</html>
<script> 
//số chỗ phải lớn hơn số chỗ tối thiểu mới có thể chọn HDV



function add_scope(){
    let scope = parseInt(document.getElementById("scope").value) || 0; // số người
    let minimum_scope = parseInt(document.getElementById("minimum_scope").value) || 0; // số tối thiểu
    let base_price = parseFloat(document.getElementById("base_price").value) || 0; // giá gốc của tour (nhiều ngày)
    let base_day = parseInt(document.getElementById("base_day").value) || 1; // số ngày tour gốc
    let number_day = parseInt(document.getElementById("number_of_days").value) || base_day; // số ngày hiện tại
    let max_scope = parseInt(document.getElementById("max_scope").value) || 0; // số ngày hiện tại

    // tính giá 1 ngày 1 người
    let price_per_day_per_person = base_price / base_day;

    // tính tổng tiền = số người × số ngày × giá 1 ngày 1 người
    let total = scope * number_day * price_per_day_per_person;

    document.getElementById("price").value = Math.round(total); // làm tròn VNĐ

    // hiển thị HDV nếu đủ số người tối thiểu
    let html = "";
    if(scope >= minimum_scope &&scope <= max_scope){
        html +=
        `
         <button type="submit" name="order_tour" class="btn btn-primary form-control" >Đặt tour</button>
        `;
    }
    document.getElementById("order_tour").innerHTML = html;

    let deposit = total*0.5;
    document.getElementById("amount_money").value = Math.round(deposit);

}

function add_number_of_days() { 
    let days = parseInt(document.getElementById("number_of_days").value) || 0;
    document.getElementById("number_of_nights").value = days - 1;

    // cập nhật lại tổng tiền
    add_scope();
}

</script>

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