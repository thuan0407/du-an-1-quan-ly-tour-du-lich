<div class="detail-wrapper">

    <h2 class="title-main">📌 Chi tiết lịch làm việc</h2>
    
    <!-- TIMELINE STEPS -->
    <div class="step-timeline">
        <?php foreach ($arr_merged as $index => $label): ?>
            <div class="step <?= ($index + 1) <= $step ? 'active' : '' ?>">
                <div class="dot"></div>
                <div class="text"><?= $label ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- BUTTONS -->
    <form action="" method="post" class="action-buttons">
        <button class="btn btn-success" type="submit" name="add"
            onclick="return confirm('Bạn đã đến địa điểm này chưa?')">Đã đến</button>

        <button class="btn btn-danger" type="submit" name="back"
            onclick="return confirm('Bạn muốn lùi lại bước trước?')">Lùi lại</button>
    </form>

    <!-- TOUR INFO -->
    <div class="info-card">
        <h3 class="section-title">🗺️ Thông tin tour</h3>

        <p><strong>Tên tour:</strong> <?= htmlspecialchars($detail->tour_name) ?></p>
        <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($detail->tour_description)) ?></p>

        <?php if (!empty($detail->days) && !empty($detail->nights)): ?>
            <p><strong>Thời lượng:</strong> 
                <?= $detail->days ?> ngày / <?= $detail->nights ?> đêm
            </p>
        <?php endif; ?>

        <?php if (!empty($detail->start_date) && !empty($detail->end_date)): ?>
        <p class="time-box">
            <strong>Thời gian:</strong>
            <span class="tag tag-blue"><?= htmlspecialchars($detail->start_date) ?></span>
            <span class="arrow">→</span>
            <span class="tag tag-green"><?= htmlspecialchars($detail->end_date) ?></span>
        </p>
        <?php endif; ?>

        <p class="time-box">
            <strong>Đón / Trả:</strong>
            <span class="tag tag-light"><?= htmlspecialchars($detail->start_location) ?></span>
            <span class="arrow">→</span>
            <span class="tag tag-light"><?= htmlspecialchars($detail->end_location) ?></span>
        </p>
    </div>

    <!-- DAILY ACTIVITIES -->
    <div class="info-card">
        <h3 class="section-title">📅 Hoạt động từng ngày</h3>

        <?php if (!empty($sts)): ?>
            <div class="act-list">
                <?php foreach ($sts as $i => $item): ?>
                    <div class="act-item">
                        <div class="act-day">Ngày <?= $i + 1 ?></div>
                        <div class="act-content"><?= htmlspecialchars($item->content) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted"><i>Chưa có hoạt động nào.</i></p>
        <?php endif; ?>
    </div>

    <!-- SERVICES -->
    <div class="info-card">
        <h3 class="section-title">🛎️ Dịch vụ & Nhà cung cấp</h3>

        <?php if (!empty($services)): ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Loại dịch vụ</th>
                    <th>Nhà cung cấp</th>
                    <th>SĐT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $sv): ?>
                <tr>
                    <td><?= htmlspecialchars($sv->service) ?></td>
                    <td><?= htmlspecialchars($sv->name_supplier) ?></td>
                    <td>0<?= htmlspecialchars($sv->phone_supplier) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-muted"><i>Không có dịch vụ.</i></p>
        <?php endif; ?>
    </div>

    <!-- CUSTOMER INFO -->
    <div class="info-card">
        <h3 class="section-title">👤 Thông tin khách đặt</h3>

        <table class="styled-table">
            <tr>
                <th>Tên khách</th>
                <td><?= htmlspecialchars($detail->CusName) ?></td>
            </tr>
            <tr>
                <th>SĐT</th>
                <td>0<?= htmlspecialchars($detail->CusPhone) ?></td>
            </tr>
            <tr>
                <th>Số khách</th>
                <td><?= htmlspecialchars($detail->quantity) ?></td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td><?= !empty($detail->note) ? nl2br(htmlspecialchars($detail->note)) : "<i class='text-muted'>Không có</i>" ?></td>
            </tr>
        </table>
    </div>

    <!-- FOOTER BUTTONS -->
    <div class="footer-btns">
        <a href="?action=schedule_guide" class="btn-back">← Quay lại</a>

        <a href="?action=updateStatusTour&id=<?= $detail->book_id ?>"
           class="btn-end"
           onclick="return confirm('Kết thúc tour này?')">✔ Kết thúc tour</a>
    </div>

</div>


<style>
/* ----------- WRAPPER ----------- */
.detail-wrapper {
    max-width: 820px;
    margin: 25px auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.12);
}

/* ----------- HEADING ----------- */
.title-main {
    font-size: 26px;
    font-weight: bold;
    text-align: center;
    background: linear-gradient(90deg,#7f5af0,#2cb1ff);
    color:transparent;
    margin-bottom: 25px;
}

/* ----------- STEP TIMELINE ----------- */
.step-timeline {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    position: relative;
}

.step-timeline::before {
    content:"";
    position:absolute;
    top: 18px;
    left:0; right:0;
    height:4px;
    background:#e4e4e4;
    z-index:1;
}

.step {
    text-align:center;
    z-index:2;
}
.step .dot {
    width: 26px;
    height: 26px;
    background:#ccc;
    border-radius:50%;
    margin:auto;
    transition:0.3s;
}

.step.active .dot {
    background:#2cb1ff;
    box-shadow: 0 0 10px #2cb1ff;
}

.step .text {
    margin-top:6px;
    font-size:13px;
    color:#666;
}
.step.active .text {
    font-weight:bold;
    color:#2cb1ff;
}

/* ----------- BUTTONS ----------- */
.action-buttons {
    display:flex;
    justify-content:center;
    gap:15px;
    margin-bottom:20px;
}

/* ----------- INFO CARD ----------- */
.info-card {
    background: #f8faff;
    padding: 18px 20px;
    border-radius: 14px;
    margin-bottom: 22px;
    border-left: 5px solid #7f5af0;
}
.section-title {
    margin-bottom:10px;
    font-size:18px;
    font-weight:700;
    color:#444;
}

/* ----------- TAG ----------- */
.tag {
    padding: 4px 10px;
    border-radius: 6px;
    font-weight:500;
}
.tag-blue { background:#2cb1ff; color:#fff; }
.tag-green { background:#28c76f; color:#fff; }
.tag-light { background:#eee; }

/* ----------- ACTIVITIES ----------- */
.act-list { display:flex; flex-direction:column; gap:14px; }
.act-item {
    background:#fff;
    border-left: 4px solid #7f5af0;
    padding: 10px 14px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.act-day {
    font-weight:bold;
    color:#7f5af0;
    margin-bottom:4px;
}

/* ----------- TABLE ----------- */
.styled-table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
.styled-table th, .styled-table td {
    padding:10px;
    border:1px solid #ddd;
}
.styled-table th {
    background:#eef4ff;
    color:#333;
    font-weight:bold;
}

/* ----------- FOOTER BUTTONS ----------- */
.footer-btns {
    display:flex;
    justify-content:space-between;
    margin-top:20px;
}

.btn-back,
.btn-end {
    padding:10px 18px;
    border-radius:8px;
    color:white;
    text-decoration:none;
    font-weight:600;
}
.btn-back { background:#1e90ff; }
.btn-back:hover { background:#0d6efd; }
.btn-end { background:#e63946; }
.btn-end:hover { background:#b51729; }
</style>
