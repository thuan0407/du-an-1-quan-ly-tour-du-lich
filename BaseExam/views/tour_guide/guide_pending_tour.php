<?php if (empty($pendingTours)): ?>
    <p>Không có tour nào đang chờ duyệt.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Tên tour</th>
            <th>Tên khách đặt</th>
            <th>SĐT</th>
            <th>Ngày đặt</th>
            <th>Ngày/Đêm</th>
            <th>Ghi chú (ngày đi)</th>
            <th>Trạng thái</th>
        </tr>

        <?php foreach ($pendingTours as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['tour_name']) ?></td>
            <td><?= htmlspecialchars($b['customername']) ?></td>
            <td><?= htmlspecialchars($b['phone']) ?></td>
            <td><?= htmlspecialchars($b['date']) ?></td>
            <td><?= $b['days'] ?> ngày - <?= $b['nights'] ?> đêm</td>
            <td><?= htmlspecialchars($b['note']) ?></td>
            <td><?= statusLabel($b['status']) ?></td>
        </tr>
        <?php endforeach; ?>

    </table>
<?php endif; ?>
<?php 
function statusLabel($status) {
    $labels = [
        1 => "<span style='color: orange; font-weight: bold;'>Chờ duyệt</span>",
        2 => "<span style='color: green; font-weight: bold;'>Đã duyệt</span>",
        3 => "<span style='color: gray; font-weight: bold;'>Đã kết thúc</span>"
    ];
    return $labels[$status] ?? "Không xác định";
}
?>
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

table th {
    background: #007bff;
    color: white;
    font-weight: bold;
    padding: 12px;
    text-align: left;
    font-size: 15px;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

table tr:hover {
    background: #f4f8ff;
}

table tr:last-child td {
    border-bottom: none;
}

/* Màu cho các trạng thái */
.status-pending {
    color: orange;
    font-weight: bold;
}

.status-approved {
    color: green;
    font-weight: bold;
}

.status-finished {
    color: gray;
    font-weight: bold;
}
</style>
