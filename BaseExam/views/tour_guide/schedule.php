<div class="schedule-container">
  <h2>🗓️ Lịch làm việc</h2>

  <?php if(!empty($schedules)): ?>

<div class="filter-container">

    <!-- Lọc tìm kiếm -->
  <input type="text" id="searchInput" placeholder="Tìm kiếm tour...">
  
  <select id="statusFilter">
    <option value="">Tất cả trạng thái</option>
    <option value="1">Chuẩn bị</option>
    <option value="2">Đang diễn ra</option>
    <option value="3">Đã kết thúc</option>
  </select>

  <label>Ngày bắt đầu:</label>
  <input type="date" id="startDate">
  <label>Ngày kết thúc:</label>
  <input type="date" id="endDate">

<!-- reset lọc  -->
  <button type="button" id="resetFilter">Reset</button>
</div>

   <div class="table-wrapper">
      <table class="schedule-table">
        <thead>
  <tr>
    <th>Tên tour</th>
    <th>Ngày bắt đầu</th>
    <th>Ngày kết thúc</th>
    <th>Ghi chú</th>
    <th>Chi tiết</th>
     <th>Trạng thái</th>   <!-- (sắp diễn ra, đang diễn ra, đã kết thúc) -->
    <th>Xem nhật ký tour</th>
    <th>Yêu cầu đặc biệt</th> <!-- (đổi phòng, ăn chay, hỗ trợ sk, ...) -->
  </tr>
</thead>

<tbody>
  <?php 
  $today = date('Y-m-d'); // ngày hiện tại
  foreach($schedules as $schedule): 

    // Tự động cập nhật trạng thái dựa theo ngày
    $auto_status = 1; // mặc định Chuẩn bị
    if ($today >= $schedule->start_date && $today <= $schedule->end_date) {
        $auto_status = 2; // Đang diễn ra
    } elseif ($today > $schedule->end_date) {
        $auto_status = 3; // Đã kết thúc
    }

    // Nếu HDV đã thay đổi status bằng select, dùng status trong CSDL
    $status = $schedule->status ?? $auto_status;

  ?>
    <tr>
      <td><?= htmlspecialchars($schedule->tour_name ?? 'Chưa có tour') ?></td>
      <td><?= htmlspecialchars($schedule->start_date) ?></td>
      <td><?= htmlspecialchars($schedule->end_date) ?></td>
      <td><?= htmlspecialchars($schedule->note) ?></td>

      <td>
        <a href="?action=schedule_detail&id=<?= $schedule->id ?>" 
           style="color:#1e90ff;font-weight:bold;">
           Xem
        </a>
      </td>

  <td class="status <?= $status == 1 ? 'status-preparing' : ($status == 2 ? 'status-ongoing' : 'status-finished') ?>">
      <form method="POST" action="?action=update_schedule_status&id=<?= $schedule->id ?>">
        <select name="status" onchange="this.form.submit()">
            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Chuẩn bị</option>
            <option value="2" <?= $status == 2 ? 'selected' : '' ?>>Đang diễn ra</option>
            <option value="3" <?= $status == 3 ? 'selected' : '' ?>>Đã kết thúc</option>
        </select>
      </form>
  </td>

<td>
    <a href="?action=tour_diary&schedule_id=<?= $schedule->id ?>" class="button journal-btn">
        Nhật ký
    </a>
</td>

<td>
    <a href="?action=special_request_index&id_book_tour=<?= $schedule->id ?>" class="button request-btn">
        Xem yêu cầu
    </a>
</td>
    </tr>
  <?php endforeach; ?>
</tbody>
      </table>  
    </div>
  <?php else: ?>
    <p class="no-schedule">Chưa có lịch làm việc</p>
  <?php endif; ?>
</div>

<style>
  .schedule-table a.button {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    color: #fff;
    transition: 0.3s;
    cursor: pointer;
}

/* Nút Nhật ký */
.schedule-table a.journal-btn {
    background-color: #1e90ff; /* xanh dương */
}

.schedule-table a.journal-btn:hover {
    background-color: #0c65c2;
}

/* Nút Yêu cầu */
.schedule-table a.request-btn {
    background-color: #28a745; /* xanh lá */
}

.schedule-table a.request-btn:hover {
    background-color: #1e7e34;
}

  .schedule-container {
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  }

  .schedule-container h2 {
    text-align: center;
    color: #1e90ff;
    margin-bottom: 20px;
  }

  .table-wrapper {
    overflow-x: auto;
  }

  .schedule-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
  }

  .schedule-table th,
  .schedule-table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
  }

  .schedule-table th {
    background-color: #1e90ff;
    color: white;
  }

  .schedule-table tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .schedule-table tr:hover {
    background-color: #d6e6ff;
  }

  .no-schedule {
    text-align: center;
    color: #555;
    font-style: italic;
    margin-top: 20px;
  }

  @media (max-width: 600px) {
    .schedule-container {
      padding: 15px 20px;
    }

    .schedule-table th,
    .schedule-table td {
      padding: 8px 10px;
      font-size: 14px;
    }
  }
  /* Trạng thái */
.status select {
    padding: 5px 8px;
    border-radius: 5px;
    border: none;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
}

/* Màu theo trạng thái */
.status-preparing select {
    background-color: #5cb85c; /* xanh lá nhạt */
}

.status-ongoing select {
    background-color: #f0ad4e; /* vàng cam */
}

.status-finished select {
    background-color: #ec3f3fff; /* xám */
}

/* Khi hover trên select */
.status select:hover {
    opacity: 0.9;
}

/* đây là phần css của lọc, tìm kiếm */
.filter-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
    margin-bottom: 20px;
    background-color: #f5f6fa;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

/* Input và select */
.filter-container input[type="text"],
.filter-container input[type="date"],
.filter-container select {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s;
}

/* Focus trên input/select */
.filter-container input[type="text"]:focus,
.filter-container input[type="date"]:focus,
.filter-container select:focus {
    outline: none;
    border-color: #1e90ff;
    box-shadow: 0 0 5px rgba(30,144,255,0.5);
}

/* Nhãn ngày */
.filter-container label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

/* Responsive nhỏ hơn 600px */
@media (max-width: 600px) {
    .filter-container {
        flex-direction: column;
        align-items: stretch;
    }
    .filter-container input[type="text"],
    .filter-container input[type="date"],
    .filter-container select {
        width: 100%;
    }
}
  /* reset lọc */
  #resetFilter {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    background-color: #ccc;
    color: #333;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

#resetFilter:hover {
    background-color: #999;
    color: #fff;
}
</style>


<!-- lọc tìm kiếm -->
<script>
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const startDateInput = document.getElementById('startDate');
const endDateInput = document.getElementById('endDate');
const table = document.querySelector('.schedule-table tbody');
const resetBtn = document.getElementById('resetFilter');

resetBtn.addEventListener('click', () => {
    // Xóa tất cả giá trị input/select
    searchInput.value = '';
    statusFilter.value = '';
    startDateInput.value = '';
    endDateInput.value = '';

    // Hiển thị tất cả hàng
    Array.from(table.rows).forEach(row => {
        row.style.display = '';
    });
});

function filterTable() {
    const searchValue = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value;
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;

    Array.from(table.rows).forEach(row => {
        const tourName = row.cells[0].textContent.toLowerCase();
        const status = row.cells[5].querySelector('select')?.value || '';
        const rowStartDate = row.cells[1].textContent; // cột start_date
        const rowEndDate = row.cells[2].textContent;   // cột end_date

        const matchSearch = tourName.includes(searchValue);
        const matchStatus = !statusValue || status === statusValue;

        let matchDate = true;
        if (startDate && endDate) {
            matchDate = (rowStartDate >= startDate && rowEndDate <= endDate);
        } else if (startDate) {
            matchDate = (rowStartDate >= startDate);
        } else if (endDate) {
            matchDate = (rowEndDate <= endDate);
        }

        row.style.display = (matchSearch && matchStatus && matchDate) ? '' : 'none';
    });
}

// Event listener
searchInput.addEventListener('input', filterTable);
statusFilter.addEventListener('change', filterTable);
startDateInput.addEventListener('change', filterTable);
endDateInput.addEventListener('change', filterTable);
</script>
