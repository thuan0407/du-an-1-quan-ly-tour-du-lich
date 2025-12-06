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
                            <th class="text-center" style="width:400px;">Tên Tour</th>
                            <th class="text-center">Thời gian</th>
                            <th class="text-center" style="width:120px;">Thanh toán</th>
                            <th class="text-center" style="width:120px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
    <?php 
        // đảm bảo có biến, tránh warning
        $tours = $tours ?? [];
    ?>

    <?php if (!empty($tours)): ?>
        <?php $i = 1; ?>
        <?php foreach ($tours as $tour): ?>
            <?php
                // 1. Tên, ngày tháng
                $tourName  = htmlspecialchars($tour->name);
                $startDate = date('d/m/Y', strtotime($tour->date));

                $numDays   = (int)$tour->number_of_days;
                $endDateRaw = date_add(date_create($tour->date), date_interval_create_from_date_string("$numDays days"));
                $endDate    = date_format($endDateRaw, "d/m/Y");
            ?>
            <tr>
                <!-- STT -->
                <td class="text-center"><?= $i++ ?></td>

                <!-- ẢNH TOUR (ĐÃ SỬA: dùng $tour->image, nằm trong foreach) -->
                <td class="text-center">
            <?php
                // Ưu tiên lấy ảnh đầu tiên trong mảng images
                $firstImg = '';

                // Trường hợp TourModel build dạng mảng images[]
                if (!empty($tour->images) && is_array($tour->images)) {
                    $firstImg = $tour->images[0];
                }
                // fallback: nếu sau này có field image đơn
                elseif (!empty($tour->image)) {
                    $firstImg = $tour->image;
                }
            ?>

            <?php if (!empty($firstImg)): ?>
                <img src="<?= htmlspecialchars($firstImg) ?>"
                    alt="Ảnh Tour"
                    style="width: 100px; height: 70px; object-fit: cover; border-radius: 1px;">
            <?php else: ?>
                <span class="text-muted small">Không có ảnh</span>
            <?php endif; ?>
        </td>

                <!-- TÊN TOUR -->
                <td class="text-dark text-primary fw-bold">
                    <?= $tourName ?> 
                </td>

                <!-- THỜI GIAN -->
                <td class="text-center">
                    <?= (int)$tour->number_of_days ?> ngày <?= (int)$tour->number_of_nights ?> đêm
                    <div class="small text-muted">
                        <?= $startDate ?> - <?= $endDate ?>
                    </div>
                </td>

                <!-- Trạng thái thanh toán -->
                <td class="text-center">
                    <?php if (!empty($tour->con_no) && $tour->con_no > 0): ?>
                        <span class="badge bg-danger">Còn nợ</span><br>
                        
                    <?php else: ?>
                        <span class="badge bg-success">Đã thanh toán</span>
                    <?php endif; ?>
                </td>


                <!-- HÀNH ĐỘNG -->
                <td class="text-center">
                    <a href="?action=tour_detail_view&id=<?= $tour->id ?>" 
                       class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    Không có tour đã kết thúc.
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