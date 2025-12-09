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

        /* Container chính */
        .content-wrapper {
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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

        /* Bố cục cho nhóm Số Ngày/Đêm và Số Chỗ/Giá (Dùng class form-group-inline) */
        .form-group-inline {
            display: flex;
            gap: 15px;
            flex-wrap: wrap; 
        }
        .form-group-inline .mb-3 {
            flex: 1 1 calc(50% - 7.5px); 
            min-width: 150px; 
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

        /* Nhóm các item có nút Xóa (Ảnh, Địa điểm, Dịch vụ, Lịch trình) */
        .img-item, .address-item, .supplier-item, .detail_plan {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px !important;
            padding: 8px;
            border: 1px dashed #ced4da;
            border-radius: 6px;
            background-color: #fcfcfc;
        }
        
        .img-item input[type="file"],
        .address-item input[type="text"],
        .supplier-item select,
        .detail_plan textarea {
            flex-grow: 1;
            margin-bottom: 0 !important;
        }

        /* Dùng cho phần chi tiết mỗi ngày */
        #plan .detail_plan {
            border: none;
            padding: 0;
            background-color: transparent;
            border-radius: 0;
        }

        /* Các tiêu đề nhỏ */
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

        /* Responsive */
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
            .img-item input, .address-item input, .supplier-item select, .detail_plan textarea {
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
<div class="content-wrapper">
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
                        <input type="number" name="number_of_nights" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label>Số chỗ:</label>
                        <input type="number" name="scope" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label>Số chỗ tối thiểu:</label>
                        <input type="number" name="minimum_scope" class="form-control" required min="1">
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
                                    <option value="<?=$sup->type_service?>"><?=$sup->type_service?> ( Nhà cung cấp <?=$sup->name_supplier?>)</option>
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
    // Hàm tạo nút Xóa (giữ nguyên)
    function createDeleteButton() {
        let deleteBtn = document.createElement("button");
        deleteBtn.setAttribute("type", "button");
        deleteBtn.setAttribute("class", "btn btn-danger ms-2");
        deleteBtn.setAttribute("onclick", "removeItem(this)");
        deleteBtn.textContent = "Xóa";
        return deleteBtn;
    }

    // ⭐ SỬA LỖI 1: Hàm Thêm Ảnh (Đảm bảo bản clone không có nút xóa gốc và thêm nút mới)
    function add_img() {
        let container = document.getElementById("imgs-item");
        let template  = container.querySelector(".img-item");
        // CloneNode(true) sao chép toàn bộ nội dung
        let clone = template.cloneNode(true);
        
        clone.querySelector("input[type='file']").value = ""; 
        
        // Thêm nút xóa vào bản clone
        clone.appendChild(createDeleteButton());
        container.appendChild(clone);
    }

    // ⭐ SỬA LỖI 2: Hàm Thêm Địa điểm
    function add_address() {
        let container = document.getElementById("address_s-item");
        let template  = container.querySelector(".address-item");
        let clone = template.cloneNode(true);
        
        clone.querySelector("input").value = "";
        
        // Thêm nút xóa vào bản clone
        clone.appendChild(createDeleteButton());
        container.appendChild(clone);
    }

    // ⭐ SỬA LỖI 3: Hàm Thêm Dịch vụ
    function add_supplier() {
        let container = document.getElementById("supplier_s-item");
        let template  = container.querySelector(".supplier-item");
        let clone = template.cloneNode(true);
        
        clone.querySelector("select").selectedIndex = 0;

        // Thêm nút xóa vào bản clone
        clone.appendChild(createDeleteButton()); 
        container.appendChild(clone);
    }
    
    // 4. Thêm Chính sách (Giữ nguyên)
    function add_policy() {
        let container = document.getElementById("policys-item");
        let template  = container.querySelector(".policy-item");
        let clone = template.cloneNode(true);
        clone.querySelector("input[type='text']").value = "";
        clone.querySelector("textarea").value = "";
        // Cần đảm bảo rằng nút xóa luôn được clone (vì nút xóa có sẵn trong template HTML)
        container.appendChild(clone);
    }

    // ⭐ SỬA LỖI 5: Xóa Tổng quát (Hàm này có thể bị lỗi cú pháp/logic trước đó) ⭐
    function removeItem(btn) {
        // Xóa item Chính sách (Policy-item phức tạp hơn)
        let policyItem = btn.closest(".policy-item");
        if (policyItem) {
             // Cần xác nhận rằng nút Xóa không phải là của Lịch trình (detail_plan) nếu chúng nằm gần nhau
            if (btn.closest(".d-flex") && btn.closest(".policy-item")) {
                btn.closest(".policy-item").remove();
            }
            return;
        }

        // Xóa item Ảnh, Địa điểm, Dịch vụ (dùng d-flex để tìm phần tử cha gần nhất)
        let itemToRemove = btn.closest(".img-item, .address-item, .supplier-item, .detail_plan");
        
        if(itemToRemove) {
            itemToRemove.remove();
        }
    }
    
    // 6. Thêm Lịch khởi hành
    function addPlan() {
        let plan = document.getElementById("plan");
        // Lấy template từ div.detail_plan đầu tiên
        let template = plan.querySelector(".detail_plan");
        let clone = template.cloneNode(true);
        
        // Reset nội dung textarea
        clone.querySelector("textarea").value = "";
        
        plan.appendChild(clone);
    }

    // 7. Xóa Lịch khởi hành (Đảm bảo ít nhất 1)
    function removePlan(btn) {
        let item = btn.parentElement;
        if (document.querySelectorAll("#plan .detail_plan").length === 1) {
            alert("Phải có ít nhất 1 ngày hoạt động!");
            return;
        }
        item.remove();
    }
</script>