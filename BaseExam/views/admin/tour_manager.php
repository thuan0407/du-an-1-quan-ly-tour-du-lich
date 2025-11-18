<?php require_once 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tour</title>
</head>
<body>
    <div class="content-wrapper">
        <h1>Quản lý tour</h1>
        <button class="btn btn-success" style="width:200px; height:40px; margin-left:100px;" data-bs-toggle="modal" data-bs-target="#add_tour_Modal">+Thêm</button>
         <!-- Modal tạo nhân viên mới-->
        <div class="modal fade" id="add_tour_Modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="?action=add_tour" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Tạo tour mới</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="">Tên tour:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Giá tour:</label>
                                <input type="text" name="price" class="form-control"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Số ngày:</label>
                                <input type="number" class="form-control" name="number_day"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Số đêm:</label>
                                <input type="number"  class="form-control" name="number_of_nights"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Số chỗ:</label>
                                <input type="number" class="form-control" name="scope"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Mô tả:</label>
                                <input type="text" class="form-control" name="describe"required>
                            </div>

                            <!-- lưu loại tour -->
                            <div class="mb-3">
                                <label for="">Loại tour:</label>
                                <select name="id_tourtype" class="form-control" required>
                                    <?php
                                    foreach($list_tour_type as $tourtype){
                                        ?>
                                        <option value="<?=$tourtype->id?>"><?=$tourtype->tour_type_name?></option >
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- lưu vào bảng ảnh -->
                            <div class="mb-3">
                                <label for="">Ảnh 1:</label>
                                <input type="file" class="form-control" name="img[]"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Ảnh 2:</label>
                                <input type="file" class="form-control" name="img[]"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Ảnh 3:</label>
                                <input type="file" class="form-control" name="img[]"required>
                            </div>

                            <!-- Lưu địa điểm -->
                            <div class="mb-3">
                                <label for="">Địa điểm 1:</label>
                                <input type="text" name="address[]" class="form-control"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Địa điểm 2:</label>
                                <input type="text" name="address[]" class="form-control"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Địa điểm 3:</label>
                                <input type="text" name="address[]" class="form-control"required>
                            </div>

                            <!-- lưu hợp đồng -->
                             <div class="mb-3">
                                <label for="">Chính sách 1:</label>
                                <input type="file" name="policy[]" class="form-control"required>
                            </div>
                            <div class="mb-3">
                                <label for="">Chính sách 2:</label>
                                <input type="file" name="policy[]" class="form-control"required>
                            </div>

                            <!-- lưu loại dịch vụ -->
                             <div class="mb-3">
                                <label for="">Loại dịch vụ 1:</label>
                                <select name="id_tour[]" id="" class="form-control" required>
                                <?php
                                foreach($list_tour_supplier as $tour_s){
                                    ?>
                                    <option value="<?=$tour_s->id?>"><?=$tour_s->type_service?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Loại dịch vụ 2:</label>
                                <select name="id_tour[]" id="" class="form-control" required>
                                <?php
                                foreach($list_tour_supplier as $tour_s){
                                    ?>
                                    <option value="<?=$tour_s->id?>"><?=$tour_s->type_service?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Loại dịch vụ 3:</label >
                                <select name="id_tour[]" id="" class="form-control" required>
                                <?php
                                foreach($list_tour_supplier as $tour_s){
                                    ?>
                                    <option value="<?=$tour_s->id?>"><?=$tour_s->type_service?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="create_tour">Thêm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên tour</th>
                    <th>Giá</th>
                    <th>Số chỗ</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php  
                 foreach($list as $tt):
                 ?>
                <tr>
                    <td>
                        <?php if(!empty($tt->images)): ?>
                    <?php foreach($tt->images as $img): ?>
                        <img src="<?=BASE_ASSETS_UPLOADSD. $img ?>" alt="" width="100" style="margin-right:5px;">
                    <?php endforeach; ?>
                <?php else: ?>
                    <img src="/uploads/default.jpg" alt="" width="100">
                <?php endif; ?>

                    </td>
                    <td><?= $tt->name ?></td>
                    <td><?= $tt->price ?></td>
                    <td><?= $tt->scope ?></td>
                    <td><?= $tt->date ?></td>
                    <td>
                        <a href="?action=delete_tour&id=<?=$tt->id?>" onclick ="return confirm('Bạn có chắc là muốn xóa tour này chứ?')" class="btn btn-danger">Xóa</a>
                        <a href="" class="btn btn-warning">Xem chi tiết</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
