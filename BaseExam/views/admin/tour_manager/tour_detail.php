<?php require_once __DIR__ . '/../navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <h1>Trang chi tiết và sửa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row" d-flex>
                <div class="col">
                    <div class="mb-3">
                        <label>Ảnh tour</label>
                        <?php foreach ($tour_detail->images as $index => $img): ?>
                            <div class="mb-2">
                                <img src="<?= BASE_URL . $img ?>" width="100" style="margin-right:5px;">
                                <input type="file" name="new_images[<?= $index ?>]">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="">Tên tour</label>
                        <input type="text" name="name" value="<?=$tour_detail->name?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Khu vực</label>
                        <select name="type_tour" class="form-control">
                            <option value="1" <?= $tour_detail->type_tour == 1 ? 'selected' : '' ?>>Nội địa</option>
                            <option value="2" <?= $tour_detail->type_tour == 2 ? 'selected' : '' ?>>Ngoại địa</option>
                        </select>
                    </div>

                    </div>
                    
                    <div class="mb-3">
                        <label for="">Giá</label>
                        <input type="number" name="price" value="<?=$tour_detail->price?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Số ngày</label>
                        <input type="number" name="number_of_days" value="<?=$tour_detail->number_of_days?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Số đêm</label>
                        <input type="number" name="number_of_nights" value="<?=$tour_detail->number_of_nights?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Số chỗ</label>
                        <input type="number" name="scope" value="<?=$tour_detail->scope?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Ngày tạo</label>
                        <input type="date" name="date" value="<?=$tour_detail->date?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Mô tả</label>
                        <input type="text" name="describe" value="<?=$tour_detail->describe?>"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" <?= $tour_detail->status == 1 ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="2" <?= $tour_detail->status == 2 ? 'selected' : '' ?>>Ngừng hoạt động</option>
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div>
                    <div class="mb-3">
                        <label for="">Loại tour</label>
                        <select name="id_tourtype" class="form-control">
                            <?php foreach($list_tour_type as $list_ty): ?>
                                <option value="<?=$list_ty->id?>"
                                    <?= $tour_detail->id_tourtype == $list_ty->id ? 'selected' : ''?>>
                                    <?= $list_ty->tour_type_name?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Địa điểm</label>
                        <?php foreach($addresses as $ad): ?>
                            <input type="text" name="address[]" value="<?= htmlspecialchars($ad['name']) ?>" class="form-control">
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label>Chính sách</label>
                        <?php foreach($policies as $po): ?>
                            <div style="text-align:center; margin-bottom:15px;"> <!-- mỗi policy 1 block -->
                                <img src="<?= BASE_URL . $po['content'] ?>" width="100" style="display:block; margin:0 auto 5px;">
                                <form action="?action=update_policy&id=<?= $po['id'] ?>" method="post" enctype="multipart/form-data">
                                    <input type="file" name="content[]" accept="image/*">
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="">Loại dịch vụ</label>
                        <?php foreach($tour_supplier as $sup): ?>
                            <div class="mb-2">
                                <select name="type_service[]" class="form-control">
                                    <?php foreach($list_tour_supplier as $list_ts): ?>
                                        <option value="<?= $list_ts->id ?>"
                                            <?= $list_ts->type_service == $sup['type_service'] ? 'selected' : '' ?>>
                                            <?= $list_ts->type_service ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-3">
                        <a class="btn btn-danger" href="?action=tour_manager_content">Quay lại</a>
                        <button type="submit" class="btn btn-primary" name="update">Lưu</button>
                    </div>

                </div>
        
            </div>
        
        </div>
        </div>


            

    </div>
</body>
</html>