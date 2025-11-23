<?php require_once __DIR__ . '/../navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tour mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="content-wrapper container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="modal-header">
            <h5 class="modal-title">Tạo tour mới</h5>
        </div>
    
        <div class="modal-body row">
            <div class="col">
                <!-- Loại tour -->
                <div class="mb-3">
                    <label>Chọn loại tour</label>
                    <select name="id_tourtype" class="form-control" required>
                        <?php foreach($list_type_tour as $ltt): ?>
                            <option value="<?=$ltt->id?>"><?=$ltt->tour_type_name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Khu vực -->
                <div class="mb-3">
                    <label>Khu vực:</label>
                    <select name="type_tour" class="form-control">
                        <option value="1">Nội địa</option>
                        <option value="2">Ngoại địa</option>
                    </select>
                </div>

                <!-- Thông tin tour -->
                <div class="mb-3">
                    <label>Tên tour:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Giá tour:</label>
                    <input type="number" name="price" class="form-control" required min="0">
                </div>
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
                    <label>Mô tả:</label>
                    <input type="text" name="describe" class="form-control" required>
                </div>
            </div>

            <div class="col">
                <!-- Ảnh tour -->
                <div class="mb-3">
                    <label>Ảnh tour</label>
                    <div id="imgs-item">
                        <div class="img-item d-flex mb-2">
                            <input type="file" name="images[]" class="form-control" required>
                            <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_img()">Thêm ảnh</button>
                </div>

                <!-- Địa điểm -->
                <div class="mb-3">
                    <label>Địa điểm</label>
                    <div id="address_s-item">
                        <div class="address-item d-flex mb-2">
                            <input type="text" name="address[]" class="form-control" required>
                            <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_address()">Thêm địa điểm</button>
                </div>

                <!-- Chính sách -->
                <div class="mb-3">
                    <label>Chính sách</label>
                    <div id="policys-item">
                        <div class="policy-item d-flex mb-2">
                            <input type="file" name="content[]" class="form-control" required>
                            <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_policy()">Thêm chính sách</button>
                </div>

                <!-- Dịch vụ -->
                <div class="mb-3">
                    <label>Dịch vụ</label>
                    <div id="supplier_s-item">
                        <div class="supplier-item d-flex mb-2">
                            <select name="name_supplier[]" class="form-control" required>
                                <?php foreach($list_toursupplier as $sup): ?>
                                    <option value="<?=$sup->type_service?>"><?=$sup->type_service?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" onclick="add_supplier()">Thêm dịch vụ</button>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a class="btn btn-danger" href="?action=tour_manager_content">Quay lại</a>
            <button type="submit" class="btn btn-primary" name="create">Lưu</button>
        </div>
    </form>
</div>

<script>
    function add_img() {
        let container = document.getElementById("imgs-item");
        let template  = container.querySelector(".img-item");
        let clone = template.cloneNode(true);
        clone.querySelector("input").value = "";
        container.appendChild(clone);
    }

    function add_address() {
        let container = document.getElementById("address_s-item");
        let template  = container.querySelector(".address-item");
        let clone = template.cloneNode(true);
        clone.querySelector("input").value = "";
        container.appendChild(clone);
    }

    function add_policy() {
        let container = document.getElementById("policys-item");
        let template  = container.querySelector(".policy-item");
        let clone = template.cloneNode(true);
        clone.querySelector("input").value = "";
        container.appendChild(clone);
    }

    function add_supplier() {
        let container = document.getElementById("supplier_s-item");
        let template  = container.querySelector(".supplier-item");
        let clone = template.cloneNode(true);
        clone.querySelector("select").selectedIndex = 0;
        container.appendChild(clone);
    }



    //////// phần xóa
    // Xóa chung cho cả địa điểm và dịch vụ
    function removeItem(btn) {
    let item = btn.closest(".img-item, .address-item, .policy-item, .supplier-item");
    if(item) item.remove();
}
</script>
</body>
</html>
