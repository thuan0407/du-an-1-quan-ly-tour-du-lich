<div class="container mt-4">
    <h2 class="mb-4">📋 Điểm danh khách</h2>

    <form method="POST" action="?action=roll_call_update">
        <input type="hidden" name="id_departure_schedule" value="<?= $id_departure_schedule ?>">

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Khách</th>
                        <th>SĐT</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($customers as $cust): ?>
                    <tr>
                        <td><?= htmlspecialchars($cust['name']) ?></td>
                        <td>0<?= htmlspecialchars($cust['phone']) ?></td>
                        <td>
                            <?= $cust['sex'] == 1 ? 'Nam' : ($cust['sex'] == 2 ? 'Nữ' : 'Khác') ?>
                        </td>
                        <td>
                            <input type="hidden" name="status[<?= $cust['id'] ?>]" value="1">
                            <div class="form-check form-switch" style="width: 100px;">
                                <input class="form-check-input" type="checkbox" 
                                    id="status_<?= $cust['id'] ?>" 
                                    name="status[<?= $cust['id'] ?>]"   
                                    value="2" checked>
                                <label class="form-check-label" for="status_<?= $cust['id'] ?>">
                                    Có mặt
                                </label>
                            </div>
                        </td>
                    </tr>   
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<div class="mb-3">
    <label for="id_address" class="form-label fw-bold">Chọn chặng</label>
    <select class="form-select form-select-lg border-primary" id="id_address" name="id_address" required>
        <option value="" disabled selected>-- Chọn chặng tour --</option>
        <?php foreach ($address as $a): ?>
            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <div class="form-text">Vui lòng chọn chặng phù hợp với khách</div>
</div>

        
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú cho phiên điểm danh</label>
            <textarea class="form-control" id="note" name="note" rows="2" placeholder="Nhập ghi chú..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu điểm danh</button>
    </form>

<div class="list-group mt-3">
    <?php foreach($rollCalls as $index => $rc): ?>
        <div class="list-group-item d-flex justify-content-between align-items-start
                    bg-light p-3 mb-2 rounded shadow-sm">
            <div class="me-3">
                <strong>Phiên <?= $index + 1 ?></strong>
            </div>
            <div class="me-3">
                <?= date('d/m/Y H:i', strtotime($rc['date'])) ?>
            </div>
            <?php if(!empty($rc['note'])): ?>
                <div class="flex-grow-1 me-3 text-muted">
                    <em>Ghi chú: <?= htmlspecialchars($rc['note']) ?></em>
                </div>
            <?php endif; ?>
            <div>
                <a href="?action=rollcall_history_detail&id_roll_call=<?= $rc['id'] ?>" 
                   class="btn btn-sm btn-outline-secondary">
                   Xem chi tiết
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</div>
<script>
document.querySelectorAll('.form-check-input').forEach(function(switchEl) {
    switchEl.addEventListener('change', function() {
        this.nextElementSibling.textContent = this.checked ? 'Có mặt' : 'Vắng ';
        this.value = this.checked ? 2 : 1;
    });
});
</script>