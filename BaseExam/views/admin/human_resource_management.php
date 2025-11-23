<?php require_once 'navbar.php';

$success = "";
$error = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'success') {
        $success = " Thành công!";
    } elseif ($_GET['msg'] === 'error') {
        $error = "Thất bại!";
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
    <div class="content-wrapper">
        <h1>QUẢN LÝ HƯỚNG DẪN VIÊN</h1>
        <!-- Tìm kiếm hướng dẫn viên -->
            <form action="index.php" method="get" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-3 " style="margin:0 100px">
                <input type="text" name="key_word" class="form-control" placeholder="Nhập từ khóa tìm kiếm...">
                <button type="submit" class="btn btn-primary" name="search_tour_guide">Tìm</button>
                <input type="hidden" name="action" value="search_tour_guide">
                <span style="color:red;"><?=$notification?></span>
            </form>

        <!-- Thông báo -->
        <?php if(!empty($success)):?>
            <div class="alert alert-success"><?=htmlspecialchars($success)?></div>
            <?php endif;?>

        <?php if(!empty($error)):?>
            <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
            <?php endif; ?>

        <div class="container" style="display:flex;">
            <form action="index.php" method="get">
                <!-- Lọc theo khu vực -->
                <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
                <label>Khu vực:</label>
                <select name="type_guide" class="form-control mb-3" onchange="this.form.submit()">
                    <option value="" <?= !isset($_GET['type_guide']) ? 'selected' : '' ?>>--Chọn khu vực--</option>
                    <option value="nội địa" <?= (isset($_GET['type_guide']) && $_GET['type_guide']=='nội địa') ? 'selected' : '' ?>>Nội địa</option>
                    <option value="ngoại địa" <?= (isset($_GET['type_guide']) && $_GET['type_guide']=='ngoại địa') ? 'selected' : '' ?>>Ngoại địa</option>
                </select>

                <!-- Lọc theo ngôn ngữ -->
                <label>Ngôn ngữ:</label>
                <select name="foreign_languages" class="form-control mb-3" onchange="this.form.submit()">
                    <option value="" <?= !isset($_GET['foreign_languages']) ? 'selected' : '' ?>>--Chọn ngôn ngữ--</option>
                    <?php foreach($list as $tt): ?>
                        <option value="<?= htmlspecialchars($tt->foreign_languages) ?>" 
                            <?= (isset($_GET['foreign_languages']) && $_GET['foreign_languages'] === $tt->foreign_languages) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tt->foreign_languages) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
                <input type="hidden" name="action" value="human_resource_management">
            </form>
            
            <button class="btn btn-success" style="width:200px; height:40px; margin-left:100px;" data-bs-toggle="modal" data-bs-target="#add_tour_guide_Modal">+Thêm</button>

            <!-- Modal tạo nhân viên mới-->
                    <div class="modal fade" id="add_tour_guide_Modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <form action="?action=add_tour_guide" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Thêm hướng dẫn viên</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="">Ảnh đại diện:</label>
                                            <input type="file" name="img" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Họ và tên:</label>
                                            <input type="text" name="name" class="form-control"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender">Giới tính:</label>
                                            <select name="sex" class="form-control"required>
                                                <option value="1">Nam</option>
                                                <option value="2">Nữ</option>
                                                <option value="3">Khác</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="">Năm khinh nghiệm:</label>
                                            <input type="number" class="form-control" name="years_experience"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Email:</label>
                                            <input type="email"  class="form-control" name="email"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Ngày sinh:</label>
                                            <input type="date" class="form-control" name="year_birth"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Khu vực:</label>
                                            <select name="type_guide" id=""required class="form-control">
                                                <option value="" disabled></option>
                                                <option value="nội địa">Nội địa</option>
                                                <option value="ngoại địa">Ngoại địa</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Số điện thoại:</label>
                                            <input type="number" class="form-control" name="phone_number"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Ngoại ngữ:</label>
                                            <input type="text" class="form-control" name="foreign_languages"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Sức khỏe:</label>
                                            <input type="text" class="form-control" name="health"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Giấy chứng nhận ngoại ngữ:</label>
                                            <input type="file" class="form-control" name="certificate"required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Mật khẩu:</label>
                                            <input type="password" name="password" class="form-control"required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="create_tour_guide">Thêm</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
        </div>
        <table class="table">
            <thead class="table table primary">
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>eamil</th>
                    <th>loại HDV</th>
                    <th>Năm kinh nghiệm</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>

                </tr>
            </thead>

            <tbody>
                <?php
                $i=1;
                $success="";
                $err="";
                foreach($list as $tt){
                    $success="";
                    $err    ="";
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$tt->name?></td>
                        <td><?=$tt->email?></td>
                        <td><?=$tt->type_guide?></td>
                        <td><?=$tt->years_experience?></td>
                        <td>
                            <img src="<?= BASE_ASSETS_UPLOADS . $tt->img ?>" alt="Ảnh đại diện" width="100" class="rounded-circle" height="100px;">
                        </td>
                        <td>
                            <?php
                            if($tt->status ===1){
                                ?>
                                    <a href="?action=change_status_tour_guide&id=<?=$tt->id?>" class="btn btn-danger" onclick=" return confirm('Bạn có chắc là muốn khóa tài khoản này không?')">Khóa</a>
                                <?php
                            }
                            else{
                                    ?>
                                    <a href="?action=change_status_tour_guide&id=<?=$tt->id?>" class="btn btn-primary" onclick=" return confirm('Bạn có chắc là muốn mở tài khoản này?')">Mở khóa</a>
                                    <?php
                                }
                                $i++;
                            ?>

                            <!-- Button to open the modal  xem chi tiết -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#detailModal<?= $tt->id ?>">Xem chi tiết</button> 
                                            <!-- Modal -->
                                            <div class="modal fade" id="detailModal<?= $tt->id ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <form action="?action=update_tour_guide&id=<?= $tt->id ?>" method="post" enctype="multipart/form-data">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Chi Tiết hướng dẫn viên</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="">Ảnh đại diện:</label>
                                                                    <img src="<?= BASE_ASSETS_UPLOADS . $tt->img ?>" alt="Ảnh đại diện" width="80">
                                                                    <input type="file" name="img" class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Họ và tên:</label>
                                                                    <input type="text" value="<?=$tt->name?>" name="name" class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="gender">Giới tính:</label>
                                                                    <select name="sex" class="form-control">
                                                                        <option value="1" <?= $tt->sex == 1 ? 'selected' : '' ?>>Nam</option>
                                                                        <option value="2" <?= $tt->sex == 2 ? 'selected' : '' ?>>Nữ</option>
                                                                        <option value="3" <?= $tt->sex == 3 ? 'selected' : '' ?>>Khác</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="">Năm khinh nghiệm:</label>
                                                                    <input type="number" value="<?=$tt->years_experience?>" class="form-control" name="years_experience">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Email:</label>
                                                                    <input type="email" value="<?=$tt->email?>" class="form-control" name="email">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Ngày sinh:</label>
                                                                    <input type="date" value="<?=$tt->year_birth?>" class="form-control" name="year_birth">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Khu vực:</label>
                                                                    <select name="type_guide" id=""required class="form-control" value="<?=$tt->type_guide?>">
                                                                        <option value="" disabled></option>
                                                                        <option value="nội địa">Nội địa</option>
                                                                        <option value="ngoại địa">Ngoại địa</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Số điện thoại:</label>
                                                                    <input type="number" value="<?=$tt->phone_number?>" class="form-control" name="phone_number">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Ngoại ngữ:</label>
                                                                    <input type="text" value="<?=$tt->foreign_languages?>" class="form-control" name="foreign_languages">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Sức khỏe:</label>
                                                                    <input type="text" value="<?=$tt->health?>" class="form-control" name="health">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="">Giấy chứng nhận ngoại ngữ:</label>
                                                                    <img src="<?= BASE_ASSETS_UPLOADS. $tt->certificate ?>" alt="Giấy chứng nhận" width="100">
                                                                    <input type="file" name="certificate" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="update_tour_guide">Sửa</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>