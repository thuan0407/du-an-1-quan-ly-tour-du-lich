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
        <h2>Tour đã kết thúc</h2>

        <div class="card shadow mb-4" style="height: 70vh; display: flex; flex-direction: column;">
            <div class="card-body p-0" style="overflow-y: auto; text-align: center;">
                
                <style>thead th { position: sticky; top: 0; background-color: #f8f9fa; z-index: 1; box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1); }</style>
                
                <table class="table table-bordered mb-0 align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px;">Stt</th>
                            <th class="text-center" style="width:100px;">hình ảnh</th>
                            <th class="text-center">Tên tour</th>
                            <th class="text-center" style="width:200px;">Tên người đặt</th>
                            <th class="text-center" style="width:150px;">Số điện thoại</th>
                            <th class="text-center" style="width:150px;">Số tiền cọc</th>
                            
                        </tr>
                    </thead>

                <tbody>
                        <?php 
                        // Kiểm tra nếu có dữ liệu
                        if (isset($tours) && count($tours) > 0): 
                            $i = 1; 
                            foreach ($tours as $item): 
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>

                                <td>
                                    <?php if (!empty($item->image)): ?>
                                        <img src="<?= $item->image ?>" class="tour-img" alt="Ảnh Tour" style="width: 100px; height: 70px; object-fit: cover; border-radius: 1px;">
                                    <?php else: ?>
                                        <span class="text-muted small">Không có ảnh</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-start  text-black">
                                    <?= htmlspecialchars($item->tour_name) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($item->user_name) ?>
                                </td>

                                <td>
                                    <?php 
                                        
                                        // Trong var_dump của bạn: phone_number thì rỗng, nhưng phone lại có số.
                                        // Đoạn này sẽ ưu tiên lấy phone_number, nếu rỗng thì lấy phone.
                                        echo !empty($item->phone_number) ? $item->phone_number : $item->phone;
                                    ?>
                                </td>

                                <td class="text-danger fw-bold">
                                    <?= number_format($item->total_amount) ?> đ
                                </td>

                                
                        
                        <?php endforeach; ?>
                        
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Chưa có đơn tour nào bị hủy.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    
</body>
</html>