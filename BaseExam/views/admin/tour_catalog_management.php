<?php require_once 'navbar.php'; 
if(isset($_GET['msg'])){
    if($_GET['msg'] === "success"){
        $success ="Thành công";
    }else if($_GET['msg'] === "error"){
        $error = "Thất bại";
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
        <h1>QUẢN LÝ DANH MỤC TOUR</h1>
      <form action=""method="post" enctype ="multipart/form-data" class="input-group mb-3" style="max-width: 400px;">
        <input type="text" class="form-control" name="name" placeholder="Nhập loại tour...">
        <button type="submit" class="btn btn-primary" name="create">+Thêm</button>
        <span  style="color:green; margin-left:10px;"><?=$success?></span>
        <span  style="color:red; margin-left:10px;">  <?=$err?></span>
      </form>

      <?php if(!empty($success)):?>
        <div class="alert alert-success"><?= htmlspecialchars($success)?></div>
        <?php endif; ?>

      <?php if(!empty($error)):?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Loại tour</th>
      <th scope="col">Ngày tạo</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    </div>
    <?php
    foreach($list_tour_type as $tt ){
        ?>
        <tr>
            <th scope="row"><?=$i?></th>
            <td><?=$tt->tour_type_name?></td>
            <td><?=$tt->date?></td>
            <td>
                <a href="?action=delete_tour_tour&id=<?=$tt->id?>" class="btn btn-danger" onclick="return confirm('bạn có chắc là muốn xóa không')">xóa</a>
                <!-- Nút sửa -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $tt->id ?>">Sửa</button>
                <!-- Modal -->
                <div class="modal fade" id="editModal<?= $tt->id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="?action=update_tour_type&id=<?= $tt->id ?>" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title">Nhập tên loại tour mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" name="tour_type_name" value="<?= $tt->tour_type_name ?>" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="update">Chấp nhận</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <?php
        $i++;
    }
    
    ?>
  
  </tbody>
    </div>
</table>


</body>
</html>

