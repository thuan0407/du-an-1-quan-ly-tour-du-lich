<?php require_once __DIR__ . '/../navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tour mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* --- CSS Tùy chỉnh bắt đầu --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding-bottom: 50px;
        }

        /* Container chính của form */
        .content-wrapper.container {
            max-width: 1200px;
            margin-top: 40px !important;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Tiêu đề form */
        .modal-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #007bff;
        }

        /* Bố cục 2 cột chính cho modal body */
        .modal-body.row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px; 
            padding: 0 15px;
        }

        /* Căn chỉnh các nhóm input */
        .mb-3 {
            margin-bottom: 20px !important;
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        /* Bố cục cho nhóm Số Ngày/Đêm và Số Chỗ/Giá (Sửa lỗi d-flex cũ) */
        .form-group-inline {
            display: flex;
            gap: 15px;
            /* Cần sửa lại HTML để nhóm 2x2 */
            /* Hiện tại đang là 4 cột, tôi sẽ tối ưu CSS để chúng tự chia 2x2 */
            flex-wrap: wrap; /* Cho phép xuống dòng */
        }
        .form-group-inline .mb-3 {
            flex: 1 1 calc(50% - 7.5px); /* Chia thành 2 cột trên 1 hàng */
            min-width: 150px; /* Đảm bảo trên màn hình nhỏ */
        }
        
        /* Các trường input/select/textarea cơ bản */
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Nhóm các item có nút Xóa (Ảnh, Địa điểm, Dịch vụ) */
        .img-item, .address-item, .supplier-item, .detail_plan, .policy-item > .d-flex {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px !important;
            padding: 8px;
            border: 1px dashed #ced4da;
            border-radius: 6px;
            background-color: #fcfcfc;
        }
        
        /* Đảm bảo input chiếm hết không gian khi không có nút Xóa */
        .img-item input[type="file"],
        .address-item input[type="text"],
        .supplier-item select,
        .detail_plan textarea,
        .policy-item > .d-flex textarea {
            flex-grow: 1;
            margin-bottom: 0 !important;
        }

        /* Dùng cho phần chi tiết mỗi ngày */
        .detail_plan {
            border: none;
            padding: 0;
            background-color: transparent;
            border-radius: 0;
        }


        /* Styling cho các nút thêm/xóa */
        .btn {
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.1s;
            white-space: nowrap; 
        }

        /* Các tiêu đề nhỏ (Chi tiết mỗi ngày, Chính sách) */
        h5 {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.3rem;
            color: #343a40;
            padding-left: 10px;
            border-left: 4px solid #007bff;
            font-weight: 600;
        }

        /* Chính sách item */
        #policys-item .policy-item {
            border: 1px solid #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        #policys-item .policy-item input[type="text"] {
            font-weight: 600;
            border: 1px solid #007bff;
            margin: 10px 0; 
        }

        /* Khối nút Lưu và Quay lại */
        .mt-3:last-child {
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            text-align: right; 
        }

        .mt-3:last-child .btn {
            padding: 10px 20px; 
            margin-left: 10px;
        }

        /* --- Responsive cơ bản --- */
        @media (max-width: 992px) {
            .modal-body.row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .form-group-inline {
                flex-direction: column;
                gap: 0;
            }
            .form-group-inline .mb-3 {
                 flex: 1 1 100%;
            }
            .img-item, .address-item, .supplier-item, .detail_plan, .policy-item > .d-flex {
                flex-direction: column;
                align-items: stretch;
            }
            .img-item input, .address-item input, .supplier-item select, .detail_plan textarea, .policy-item > .d-flex textarea {
                width: 100%;
                margin-bottom: 5px !important;
            }
            .img-item button, .address-item button, .supplier-item button, .detail_plan button, .policy-item > .d-flex button {
                width: 100%;
                margin-left: 0 !important;
            }
        }
        /* --- CSS Tùy chỉnh kết thúc --- */
    </style>
</head>
<body>
<div class="content-wrapper container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <h5 class="modal-title">Tạo tour mới</h5>
        </div>
    
        <div class="modal-body row">
            <div class="col">
                <div class="mb-3">
                    <label>Chọn loại tour</label>
                    <select name="id_tourtype" class="form-control" required>
                        <?php foreach($list_type_tour as $ltt): ?>
                            <option value="<?=$ltt->id?>"><?=$ltt->tour_type_name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Khu vực:</label>
                    <select name="type_tour" class="form-control">
                        <option value="1">Nội địa</option>
                        <option value="2">Ngoại địa</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tên tour:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group-inline">
                    <div class="mb-3">
                        <label>Số ngày:</label>
                        <input type="number" name="number_of_days" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label>Số đêm:</label>
                        <input type="number" name="number_of_nights" class="form-control" required min="0">
                    </div>
                    <div class="mb-3">
                        <label>Số chỗ:</label>
                        <input type="number" name="scope" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label>Giá:</label>
                        <input type="number" name="price" class="form-control" required min="1">
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label>Ảnh tour</label>
                    <div id="imgs-item">
                        <div class="img-item d-flex mb-2">
                            <input type="file" name="images[]" class="form-control" required>
                            </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_img()">Thêm ảnh</button>
                </div>

                <div class="mb-3">
                    <label>Địa điểm</label>
                    <div id="address_s-item">
                        <div class="address-item d-flex mb-2">
                            <input type="text" name="address[]" class="form-control" required>
                            </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_address()">Thêm địa điểm</button>
                </div>

                <div class="mb-3">
                    <label>Dịch vụ</label>
                    <div id="supplier_s-item">
                        <div class="supplier-item d-flex mb-2">
                            <select name="name_supplier[]" class="form-control" required>
                                <?php foreach($list_toursupplier as $sup): ?>
                                    <option value="<?=$sup->type_service?>"><?=$sup->type_service?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_supplier()">Thêm dịch vụ</button>
                </div>
            </div>
        </div>

        <div>
             <div class="mb-3">
                    <label>Mô tả:</label>
                <textarea
                     placeholder="Nội dung..." class="form-control" name="describe" rows="5" required>
                </textarea>
            </div><br>

            <h5>Chi tiết mỗi ngày LKH</h5> 
                <div >
                    <div id="plan">
                        <div class="detail_plan d-flex gap-2 mt-2">
                            <textarea placeholder="Nội dung..." class="form-control" name="detailed_content_every_day[]" rows="3" required></textarea>
                            <button type="button" class="btn btn-danger" onclick="removePlan(this)">Xóa</button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success mt-2" onclick="addPlan()">Thêm</button>
                </div><br><br>

            <div class="mb-3">
                    <h5>Chính sách</h5>
                    <div id="policys-item">
                        <div class="policy-item mb-2">
                            <input type="text" class="form-control" style="margin:10px 0" name="title[]" placeholder="Tiêu đề..." required> <br>
                            <div class="d-flex">
                                <textarea  
                                    placeholder="Nội dung..." class="form-control" name="content[]" rows="3" required>
                                </textarea>

                                <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_policy()">Thêm chính sách</button>
                </div>
        </div>

        <div class="mt-3">
            <a class="btn btn-danger" href="?action=tour_manager_content">Quay lại</a>
            <button type="submit" class="btn btn-primary" name="create">Lưu</button>
        </div>
    </form>
</div>

<script>
    // Hàm tạo nút Xóa (giúp code gọn hơn)
    function createDeleteButton() {
        let deleteBtn = document.createElement("button");
        deleteBtn.setAttribute("type", "button");
        deleteBtn.setAttribute("class", "btn btn-danger ms-2");
        deleteBtn.setAttribute("onclick", "removeItem(this)");
        deleteBtn.textContent = "Xóa";
        return deleteBtn;
    }

    // 1. Thêm Ảnh: Thêm nút Xóa cho bản clone
    function add_img() {
        let container = document.getElementById("imgs-item");
        let template  = container.querySelector(".img-item");
        let clone = template.cloneNode(true);
        
        clone.querySelector("input[type='file']").value = ""; 
        
        clone.appendChild(createDeleteButton()); // ⭐ THÊM NÚT XÓA ⭐
        container.appendChild(clone);
    }

    // 2. Thêm Địa điểm: Thêm nút Xóa cho bản clone
    function add_address() {
        let container = document.getElementById("address_s-item");
        let template  = container.querySelector(".address-item");
        let clone = template.cloneNode(true);
        
        clone.querySelector("input").value = "";
        
        clone.appendChild(createDeleteButton()); // ⭐ THÊM NÚT XÓA ⭐
        container.appendChild(clone);
    }

    // 3. Thêm Dịch vụ: Thêm nút Xóa cho bản clone
    function add_supplier() {
        let container = document.getElementById("supplier_s-item");
        let template  = container.querySelector(".supplier-item");
        let clone = template.cloneNode(true);
        
        clone.querySelector("select").selectedIndex = 0;

        clone.appendChild(createDeleteButton()); // ⭐ THÊM NÚT XÓA ⭐
        container.appendChild(clone);
    }
    
    // 4. Thêm Chính sách: giữ nguyên (luôn có nút xóa)
    function add_policy() {
        let container = document.getElementById("policys-item");
        let template  = container.querySelector(".policy-item");
        let clone = template.cloneNode(true);
        // Reset tiêu đề và nội dung
        clone.querySelector("input[type='text']").value = "";
        clone.querySelector("textarea").value = "";
        container.appendChild(clone);
    }

    // ⭐ 5. Xóa Tổng quát (Đã sửa lỗi Chính sách) ⭐
    function removeItem(btn) {
        // Kiểm tra xem nút xóa có nằm trong policy-item không
        let policyItem = btn.closest(".policy-item");
        if (policyItem) {
            policyItem.remove(); // Xóa toàn bộ khối chính sách
            return;
        }

        // Nếu không phải Chính sách, tìm item gần nhất (Ảnh, Địa điểm, Dịch vụ)
        let itemToRemove = btn.closest(".img-item, .address-item, .supplier-item");
        
        // Đảm bảo item này là bản clone (chỉ các bản clone mới có nút Xóa)
        if(itemToRemove) {
            itemToRemove.remove();
        }
    }
    
    // 6. Thêm Lịch khởi hành
    function addPlan() {
        let plan = document.getElementById("plan");
        let item = plan.querySelector(".detail_plan").cloneNode(true);
        item.querySelector("textarea").value = "";
        plan.appendChild(item);
    }

    // 7. Xóa Lịch khởi hành (Đảm bảo ít nhất 1)
    function removePlan(btn) {
        let item = btn.parentElement;

        if (document.querySelectorAll(".detail_plan").length === 1) {
            alert("Phải có ít nhất 1 ngày hoạt động!");
            return;
        }
        item.remove();
    }
</script>
</body>
</html>