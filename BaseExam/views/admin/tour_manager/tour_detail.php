<?php require_once __DIR__ . '/../navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* --- CSS TÙY CHỈNH BẮT ĐẦU --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f7; 
            color: #333;
         
        }

        /* Container chính */
        .content-wrapper {
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 30px;
            font-size: 2rem;
            color: #007bff; 
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        /* Định dạng chung cho input/select/textarea */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* --- CĂN CHỈNH BỐ CỤC 2 CỘT CON (Giá, Số chỗ, Số ngày, Số đêm) --- */
        .input-group-2x {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .input-group-2x .mb-3 {
            flex: 1; /* Chia đều không gian giữa các input */
            margin-bottom: 0 !important;
        }

        /* Định dạng Ảnh tour */
        .img-edit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fff;
            margin-bottom: 10px !important;
        }
        .img-edit-item input[type="file"] {
            flex-grow: 1;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 0 !important;
        }

        /* Định dạng các khối lặp lại (Địa điểm, Dịch vụ) */
        #address-item > div, 
        #service-item > div {
            background: #f8f8f8;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 8px;
        }
        #address-item > div input,
        #service-item > div select {
            flex-grow: 1;
            margin-bottom: 0;
        }

        /* Định dạng Chính sách */
        .policy-item {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px !important;
        }
        .policy-item textarea {
            margin-bottom: 10px !important;
        }

        /* Nút */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
        }
        
        .btn-success {
            padding: 8px 15px;
            margin-top: 10px;
        }
        
        .mt-3 {
            text-align: right;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .mt-3 .btn {
            margin-left: 10px;
        }

        /* Responsive cơ bản */
        @media (max-width: 768px) {
            .content-wrapper {
                margin: 20px;
                padding: 20px;
            }
            /* Chuyển các trường số thành 1 cột trên di động */
            .input-group-2x {
                flex-direction: column;
                gap: 0;
            }
        }
        /* --- CSS TÙY CHỈNH KẾT THÚC --- */
    </style>
</head>
<body>
<div class="content-wrapper">
    <h1>Chi tiết và sửa tour</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-md-6">
                
                <div class="mb-3">
                    <label>Ảnh tour</label>
                    <?php foreach ($tour_detail->images as $index => $img): ?>
                        <div class="img-edit-item mb-2">
                            <img src="<?= BASE_URL . $img ?>" alt="Ảnh tour" class="img-fluid">
                            <input type="file" name="new_images[<?= $index ?>]" class="form-control">
                            <input type="hidden" name="old_images[<?= $index ?>]" value="<?= htmlspecialchars($img) ?>"> 
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeImageItem(this)">Xóa ảnh</button>
                        </div>
                    <?php endforeach; ?>
                    <div id="image-add-container"></div>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_image_field()">Thêm ảnh mới</button>
                </div>

                <div class="mb-3">
                    <label for="">Tên tour</label>
                    <input type="text" name="name" value="<?=$tour_detail->name?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="">Khu vực</label>
                    <select name="type_tour" class="form-control">
                        <option value="1" <?= $tour_detail->type_tour == 1 ? 'selected' : '' ?>>Nội địa</option>
                        <option value="2" <?= $tour_detail->type_tour == 2 ? 'selected' : '' ?>>Ngoại địa</option>
                    </select>
                </div>

                <div class="input-group-2x">
                    <div class="mb-3">
                        <label for="">Giá</label>
                        <input type="number" name="price" value="<?=$tour_detail->price?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Số chỗ</label>
                        <input type="number" name="scope" value="<?=$tour_detail->scope?>" class="form-control">
                    </div>
                </div>

                <div class="input-group-2x">
                    <div class="mb-3">
                        <label for="">Số ngày</label>
                        <input type="number" name="number_of_days" value="<?=$tour_detail->number_of_days?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Số đêm</label>
                        <input type="number" name="number_of_nights" value="<?=$tour_detail->number_of_nights?>" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="">Ngày tạo</label>
                    <input type="date" name="date" value="<?=$tour_detail->date?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" <?= $tour_detail->status == 1 ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="2" <?= $tour_detail->status == 2 ? 'selected' : '' ?>>Ngừng hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="">Loại tour</label>
                    <select name="id_tourtype" class="form-control">
                        <?php foreach($list_tour_type as $list_ty): ?>
                            <option value="<?=$list_ty->id?>" <?= $tour_detail->id_tourtype == $list_ty->id ? 'selected' : ''?>><?= $list_ty->tour_type_name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Địa điểm</label>
                    <div id="address-item">
                        <?php foreach($addresses as $ad): ?>
                            <div class="d-flex align-items-start mb-2">
                                <input type="text" name="address[]" value="<?= htmlspecialchars($ad['name']) ?>" class="form-control">
                                <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_address()">Thêm địa điểm</button>
                </div>

                <div class="mb-3">
                    <label>Dịch vụ</label>
                    <div id="service-item">
                        <?php foreach($tour_supplier as $sup): ?>
                            <div class="d-flex align-items-start mb-2">
                                <select name="type_service[]" class="form-control">
                                    <?php foreach($list_tour_supplier as $list_ts): ?>
                                        <option value="<?= $list_ts->id ?>" <?= $list_ts->id == $sup['id'] ? 'selected' : '' ?>><?= $list_ts->type_service ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_service()">Thêm dịch vụ</button>
                </div>
            </div>
             <div class="mb-3">
                    <label for="">Mô tả</label>
                    <textarea name="describe" class="form-control" rows="3"><?=$tour_detail->describe?></textarea>
                </div>

                <div class="mb-3">
                    <label>Chính sách</label>
                    <div id="policys-item">
                        <?php foreach ($policies as $po): ?>
                            <div class="policy-item mb-2">
                                <input type="text" name="title[]" class="form-control mb-1" value="<?= htmlspecialchars($po['title'] ?? '') ?>" placeholder="Tiêu đề">
                                <textarea name="content[]" class="form-control mb-1" rows="3" placeholder="Nội dung"><?= htmlspecialchars($po['content'] ?? '') ?></textarea>
                                <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_policy()">Thêm chính sách</button>
                </div>


                <div class="mb-3" id="schedule-item">
                    <label>Lịch trình tour</label>
                    <?php foreach($schedules as $index => $schedule): ?>
                        <div class="d-flex mb-2 align-items-start schedule-row">    
                            <!-- ID Lịch trình -->
                            <input type="hidden" name="schedule_id[]" value="<?= $schedule['id'] ?>">
                            <span class="me-2 fw-bold">Ngày <?= $index + 1 ?>:</span>     
                            <textarea name="schedule_content[]" class="form-control me-2" placeholder="Nội dung..."><?= htmlspecialchars($schedule['content'] ?? '') ?></textarea>       
                            <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-success mt-2" onclick="add_schedule()">Thêm ngày</button>



                <div class="mt-3">
                    <a class="btn btn-danger" href="?action=tour_manager_content">Quay lại</a>
                    <button type="submit" class="btn btn-primary" name="update">Lưu</button>
                </div>
        </div>
    </form>
</div>

<script>
// Biến đếm ảnh mới (giữ nguyên)
let newImageIndex = <?= count($tour_detail->images) ?>; 

/**
 * Hàm xóa tổng quát và xử lý cập nhật số ngày lịch trình.
 * @param {HTMLButtonElement} btn - Nút 'Xóa' được click.
 */
function removeItem(btn) {
    const parentContainer = btn.closest(".d-flex, .img-edit-item, .policy-item");
    if (!parentContainer) return;

    // 1. Thực hiện xóa phần tử
    parentContainer.remove();

    // 2. Nếu phần tử bị xóa thuộc Lịch trình, thực hiện cập nhật lại số ngày
    const scheduleContainer = document.getElementById('schedule-item');
    // Kiểm tra xem phần tử bị xóa có nằm trong container lịch trình hay không
    if (scheduleContainer && scheduleContainer.contains(parentContainer)) {
        updateScheduleDayNumbers();
    }
}

/**
 * Hàm cập nhật lại số thứ tự của các ngày trong Lịch trình.
 */
function updateScheduleDayNumbers() {
    const container = document.getElementById('schedule-item');
    if (container) {
        // Chỉ chọn các div.d-flex là con trực tiếp, không phải div của các phần khác
        container.querySelectorAll('div.d-flex').forEach((div, idx) => {
            // Đảm bảo chỉ cập nhật lại số ngày nếu có tag span chứa số ngày
            const daySpan = div.querySelector('span.fw-bold');
            if (daySpan) {
                daySpan.textContent = `Ngày ${idx + 1}:`;
            }
        });
    }
}


// --- Thêm ảnh mới
function add_image_field() {
    const container = document.getElementById("image-add-container");
    const div = document.createElement("div");
    div.classList.add("img-edit-item", "mb-2");
    div.innerHTML = `
        <img src="https://via.placeholder.com/100?text=Mới" alt="Ảnh mới" class="img-fluid">
        <input type="file" name="new_images[${newImageIndex}]" class="form-control" required>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Xóa ảnh</button>`;
    
    container.appendChild(div);
    newImageIndex++;
}

// Hàm này không còn cần thiết vì đã gộp vào removeItem, nhưng nếu muốn giữ để dễ đọc:
function removeImageItem(btn) {
    removeItem(btn); 
}


// --- Thêm Địa điểm
function add_address(){
    const container = document.getElementById("address-item");
    const div = document.createElement("div");
    div.classList.add("d-flex", "align-items-start", "mb-2");
    div.innerHTML = `<input type="text" name="address[]" class="form-control" placeholder="Địa điểm...">
                     <button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>`;
    container.appendChild(div);
}

// --- Thêm Dịch vụ 
function add_service(){
    const container = document.getElementById("service-item");
    const div = document.createElement("div");
    div.classList.add("d-flex", "align-items-start", "mb-2");
    
    // Lấy nội dung select PHP 
    const selectOptions = `
        <select name="type_service[]" class="form-control">
            <?php foreach($list_tour_supplier as $list_ts): ?>
            <option value="<?= $list_ts->id ?>"><?= $list_ts->type_service ?></option>
            <?php endforeach; ?>
        </select>`;
        
    div.innerHTML = selectOptions + `<button type="button" class="btn btn-danger ms-2" onclick="removeItem(this)">Xóa</button>`;
    container.appendChild(div);
}

// --- Thêm Chính sách 
function add_policy(){
    const container = document.getElementById("policys-item");
    const div = document.createElement("div");
    div.classList.add("policy-item", "mb-2");
    div.innerHTML = `<input type="text" name="title[]" class="form-control mb-1" placeholder="Tiêu đề...">
                     <textarea name="content[]" class="form-control mb-1" rows="3" placeholder="Nội dung..."></textarea> 
                     <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>`;
    container.appendChild(div);
}

// --- Thêm ngày lịch trình (Đã sửa để gọi hàm cập nhật) ---
function add_schedule() {
    let container = document.getElementById('schedule-item');
    let dayCount = container.querySelectorAll('div.d-flex').length + 1; // Số ngày mới
    let div = document.createElement('div');
    div.classList.add('d-flex', 'mb-2', 'align-items-start', 'schedule-row');
    div.innerHTML = `
        <input type="hidden" name="schedule_id[]" value="">
        <span class="me-2 fw-bold">Ngày ${dayCount}:</span>
        <textarea name="schedule_content[]" class="form-control me-2" placeholder="Nội dung..."></textarea>
        <button type="button" class="btn btn-danger" onclick="removeItem(this)">Xóa</button>
    `;
    container.appendChild(div);
}

 </script>


</body>
</html>