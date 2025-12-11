<div class="container mt-4">
    <h2 class="mb-4">📋 Chi tiết phiên điểm danh #<?= $rollCall['id'] ?></h2>

    <?php if(!empty($rollCall['note'])): ?>
        <p><strong>Ghi chú:</strong> <?= htmlspecialchars($rollCall['note']) ?></p>
    <?php endif; ?>

    <?php
        $address = $details[0]['address_name'] ?? '';
        if($address):
    ?>
        <p><strong>Chặng:</strong> <?= htmlspecialchars($address) ?></p>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Khách</th>
                    <th>SĐT</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($details as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['name']) ?></td>
                    <td>0<?= htmlspecialchars($d['phone']) ?></td>
                    <td>
                        <?php if($d['status'] == 2): ?>
                            <span class="badge bg-success">Có mặt</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Vắng mặt</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="?action=roll_call_form&id_departure_schedule=<?= $rollCall['id_departure_schedule'] ?>" class="btn btn-secondary mt-3">Quay lại</a>
</div>
