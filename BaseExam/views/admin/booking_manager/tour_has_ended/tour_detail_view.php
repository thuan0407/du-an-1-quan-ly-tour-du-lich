<?php require_once __DIR__ . '/../../navbar.php'; ?>
<?php require_once __DIR__ . '/../nav_booking.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Tour #<?= $tour->id ?? 'Unknown' ?></title>
    <!-- CSS Bootstrap 5 (Nếu chưa có trong navbar) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .detail-label { font-weight: 600; color: #555; width: 140px; display: inline-block; }
        .card-header-custom { background-color: #e3f2fd; color: #0d6efd; font-weight: bold; text-transform: uppercase; }
        .ss-gap { gap: 20px; }
    </style>
</head>
<body class="bg-light">

<?php
// ====== CHUẨN HÓA DỮ LIỆU TỪ DB ======
// Ở đây chỉ map đúng tên cột DB sang biến đang dùng trong view

// Tiêu đề & mô tả & giá
$tourName   = $tour->name          ?? '';          // CHANGED: ten_tour -> name
$tourPrice  = $tour->price         ?? 0;           // CHANGED: gia_niem_yet -> price
$tourDesc   = $tour->describe      ?? '';          // CHANGED: mota -> describe

// Ngày đi: dùng cột `date` trong bảng tour
$startDateRaw = $tour->date        ?? null;        // CHANGED: start_date -> date

// Ngày về: tạm tính = ngày đi + number_of_days
// (nếu m không thích tính, m có thể tạo cột end_date trong DB rồi in thẳng ra)
$endDateRaw = null;
if (!empty($startDateRaw) && !empty($tour->number_of_days)) {   // CHANGED: tự tính endDate từ DB có sẵn
    $endDateRaw = date('Y-m-d', strtotime($startDateRaw . ' + ' . (int)$tour->number_of_days . ' days'));
}
?>

<div class="content-wrapper p-4">
    
    <!-- HEADER: TIÊU ĐỀ & NÚT BACK -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="text-primary m-0">
            Chi tiết Tour đã kết thúc
        </h2>
        <a href="?action=tour_has_ended" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <!-- NỘI DUNG CHÍNH (Chia cột) -->
    <div class="row ss-gap">
        
        <!-- CỘT TRÁI: THÔNG TIN CƠ BẢN & LỊCH TRÌNH -->
        <div class="col-md-6">
            <!-- 1. THÔNG TIN TOUR -->
            <div class="card shadow mb-2">
                <div class="card-header card-header-custom ">
                    Thông tin chung
                </div>
                <div class="card-body">
                    <!-- CHANGED: dùng $tourName (name) thay cho ten_tour -->
                    <h3 class="text-primary fw-bold mb-3">
                        <?= htmlspecialchars($tourName !== '' ? $tourName : 'Tên Tour Lỗi') ?>
                    </h3>
                    
                    <ul class="list-group list-group-flush">
                        
                        <li class="list-group-item">
                            <span class="detail-label">Giá vé:</span> 
                            <!-- CHANGED: tourPrice (price) thay cho gia_niem_yet -->
                            <span class="text-danger fw-bold fs-5">
                                <?= number_format($tourPrice) ?> đ
                            </span>
                        </li>
                        <li class="list-group-item">
                            <span class="detail-label">Thời lượng:</span> 
                            <?= (int)($tour->number_of_days ?? 0) ?> ngày 
                            <?= (int)($tour->number_of_nights ?? 0) ?> đêm
                        </li>
                    </ul>

                    <div class="mt-3 p-3 bg-light rounded border">
                        <label class="fw-bold mb-1">Mô tả:</label>
                        <p class="mb-0 text-muted fst-italic">
                            <!-- CHANGED: tourDesc (describe) thay cho mota -->
                            <?= $tourDesc !== '' 
                                ? nl2br(htmlspecialchars($tourDesc)) 
                                : 'Chưa có mô tả chi tiết.' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. LỊCH TRÌNH & HẬU CẦN -->
            <div class="card shadow mb-4">
                <div class="card-header card-header-custom bg-warning text-dark bg-opacity-25">
                    Lịch trình & Hậu cần
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold text-success">Ngày đi</h6>
                            <!-- CHANGED: dùng date từ cột `date` -->
                            <p class="fs-5">
                                <?= $startDateRaw 
                                    ? date('d/m/Y', strtotime($startDateRaw)) 
                                    : 'Chưa cập nhật' ?>
                            </p>
                        </div>
                        <div class="col-md-6 ps-4">
                            <h6 class="fw-bold text-danger">Ngày về</h6>
                            <!-- CHANGED: dùng endDateRaw đã tính ở trên -->
                            <p class="fs-5">
                                <?= $endDateRaw 
                                    ? date('d/m/Y', strtotime($endDateRaw)) 
                                    : 'Chưa cập nhật' ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Danh sách Nhà cung cấp (Vòng lặp nhỏ) -->
                    <h6 class="fw-bold mt-3"><i class="fas fa-truck"></i> Nhà cung cấp dịch vụ:</h6>

                    <?php if (!empty($suppliers)): ?>
                        <p class="mt-2 mb-0">
                            <?php
                            $items = [];
                            foreach ($suppliers as $ncc) {
                                // "Tên nhà cung cấp - loại dịch vụ"
                                $items[] = htmlspecialchars($ncc->name) . ' - ' . htmlspecialchars($ncc->type_service);
                            }
                            echo implode('; ', $items);
                            ?>
                        </p>
                    <?php else: ?>
                        <p class="text-muted small mb-0">Chưa cập nhật nhà cung cấp.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: TÀI CHÍNH & NHÂN SỰ -->
        <div class="col-md-5">
            
            <!-- 3. TỔNG KẾT TÀI CHÍNH -->
            <div class="card shadow mb-5 border-danger">
                <div class="card-header bg-danger text-white card-header-custom">
                    Tổng kết Tài chính
                </div>
                <div class="card-body text-center">
                    <?php 
                        // LƯU Ý:
                        // Hiện tại bảng `tour` KHÔNG có các cột tong_tien_don_hang, tong_thuc_thu, incidental_costs.
                        // Nếu không join thêm bảng khác thì 3 biến này sẽ = 0.
                        $doanh_thu = $tour->tong_tien_don_hang ?? 0;
                        $thuc_thu  = $tour->tong_thuc_thu ?? 0;
                        $phat_sinh = $tour->incidental_costs ?? 0;

                        // Còn nợ = doanh thu - thực thu (logic cũ của m, tao giữ nguyên)
                        $con_no = $doanh_thu - $thuc_thu;
                    ?>

                    <div class="mb-3">
                        <small class="text-muted text-uppercase d-block">Tổng doanh thu</small>
                        <span class="text-primary fw-bold fs-3 text-black"><?= number_format($doanh_thu) ?> đ</span>
                    </div>

                    <div class="mb-3 border-top pt-2">
                        <div class="d-flex justify-content-between">
                            <span class="text-success"><i class="fas fa-check-circle"></i> Đã thu:</span>
                            <span class="fw-bold"><?= number_format($thuc_thu) ?> đ</span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> Còn nợ:</span>
                            <span class="fw-bold text-danger"><?= number_format($con_no) ?> đ</span>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                        <button type="button"
                                class="btn btn-lg bg-danger btn-sm text-white"
                                onclick="confirmPaid(<?= (int)$tour->id ?>)">
                            Đã thanh toán
                        </button>
                    </div>

                    <script>
                    function confirmPaid(tourId) {
                        if (!confirm('Xác nhận khách hàng đã thanh toán tour này?')) {
                            return;
                        }
                        if (!confirm('Xác nhận thanh toán và không thể hoàn tác?')) {
                            return;
                        }
                        window.location.href = '?action=mark_tour_paid&id=' + tourId;
                    }
                    </script>

                    </div>

                    <?php if ($phat_sinh > 0): ?>
                    <div class="alert alert-warning mb-0 p-2 small">
                        <strong>Phát sinh:</strong> <?= number_format($phat_sinh) ?> đ
                        <br>(Chi phí vận hành)
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 4. HƯỚNG DẪN VIÊN -->
            <!-- 4. HƯỚNG DẪN VIÊN -->
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white card-header-custom">
        Hướng dẫn viên
    </div>
    <div class="card-body">
        <?php if (!empty($guide)): ?>
            <div class="d-flex align-items-center mb-3">
                <div class="bg-light rounded-circle p-3 me-3 text-primary">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <div>
                    <h5 class="fw-bold m-0">
                        <?= htmlspecialchars($guide->name) ?>
                    </h5>
                    <small class="text-muted">Phụ trách chính</small>
                </div>
            </div>

            <p class="mb-1">
                <i class="fas fa-phone-alt text-success me-2"></i>
                <a href="tel:<?= htmlspecialchars($guide->phone_number) ?>"
                   class="text-decoration-none">
                    <?= htmlspecialchars($guide->phone_number) ?>
                </a>
            </p>
            <p class="mb-0">
                <i class="fas fa-envelope text-secondary me-2"></i>
                <?= htmlspecialchars($guide->email) ?>
            </p>
        <?php else: ?>
            <em class="text-muted">Chưa phân công.</em>
        <?php endif; ?>
    </div>
</div>


        </div> <!-- Hết cột phải -->
    
    </div> <!-- Hết row chính -->

    <div class="card shadow border-0 mb-4 overflow-hidden">
        <div class="card-header text-white fw-bold py-3" style="background-color: #0d6efd; font-size: 1.1rem; card-header-custom">
            BẢNG GHI CHÚ
        </div>

        <div class="card-body p-4 bg-white">
            <div class="mb-4">
                <div class="d-flex align-items-end">
                    <span class=" fw-bold text-muted small me-2" style="min-width: 80px;">
                        Ghi chú khách hàng:
                    </span>
                    <div class="flex-grow-1" style="border-bottom: 2px dashed #dee2e6; height: 1px;"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex align-items-end">
                    <span class=" fw-bold text-muted small me-2" style="min-width: 80px;">
                        Ghi chú lịch khởi hành:
                    </span>
                    <div class="flex-grow-1" style="border-bottom: 2px dashed #dee2e6; height: 1px;"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex align-items-end">
                    <span class="fw-bold text-muted small me-2" style="min-width: 80px;">
                        Ghi chú thanh toán:
                    </span>
                    <div class="flex-grow-1" style="border-bottom: 2px dashed #dee2e6; height: 1px;"></div>
                </div>
            </div>

            <div class="mt-2 pt-3 border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark" style="font-size: 1.1rem;">
                        <i class="fas fa-user-check text-success me-2"></i> Điểm danh:
                    </span>
                    
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                        Chưa cập nhật
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- BLOCK CUỐI: ĐÁNH GIÁ & NHẬT KÝ -->
    <div class="card shadow mt-2">
        <div class="card-header bg-light fw-bold">
            <i class="fas fa-star-half-alt text-warning me-1"></i> Đánh giá & Nhật ký tour
        </div>
        <div class="card-body">
            <div class="text-center py-4 text-muted">
                <i class="fas fa-comment-dots fa-2x mb-2"></i><br>
                Chưa có nhật ký nào được ghi lại.
            </div>
        </div>
    </div>

</div>

</body>
</html>
