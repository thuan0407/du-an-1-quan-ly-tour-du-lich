<div class="schedule-container">
  <h2>🗓️ Lịch làm việc</h2>

  <?php if(!empty($schedules)): ?>

<div class="filter-container">

    <!-- Lọc tìm kiếm -->
  <input type="text" id="searchInput" placeholder="Tìm kiếm tour...">
  
  <select id="statusFilter">
    <option value="">Tất cả trạng thái</option>
    <option value="2">Đang hoạt động</option>
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
    <th>Điểm danh</th>
    <th>Chi tiết</th>
    <th>Trạng thái</th>   <!-- (sắp diễn ra, đang diễn ra, đã kết thúc) -->
    <th>Xem nhật ký tour</th>
    <th>Yêu cầu đặc biệt</th> <!-- (đổi phòng, ăn chay, hỗ trợ sk, ...) -->
  </tr>
</thead>

<tbody>
  <?php 
  foreach($schedules as $schedule): 
  ?>
    <tr>
      <td><?= htmlspecialchars($schedule->tour_name ?? 'Chưa có tour') ?></td>
      <td><?= htmlspecialchars($schedule->start_date) ?></td>
      <td><?= htmlspecialchars($schedule->end_date) ?></td>

    <td>
    <a href="?action=roll_call_form&id_departure_schedule=<?= $schedule->id ?>" 
       class="button journal-btn" 
       style="background:#ff9800;">
       Điểm danh
    </a>
  </td>

      <td>
        <a href="?action=schedule_detail&id=<?= $schedule->id ?>" 
           style="color:#1e90ff;font-weight:bold;">
           Xem
        </a>
      </td>

<td class="status <?= $schedule->st == 2 ? 'status-ongoing' : ($schedule->st == 3 ? 'status-finished' : 'status-preparing') ?>">
    <?php 
    if ($schedule->st == 2) {
        echo "<span class='status-icon' style='color: #5cb85c;'>🟢 Đang hoạt động</span>";
    } elseif ($schedule->st == 3) {
        echo "<span class='status-icon' style='color: #ec3f3f;'>🟥 Đã kết thúc</span>";
    } 
    ?>
</td>




<td>
    <a href="?action=tour_diary&schedule_id=<?= $schedule->id ?>" class="button journal-btn">
        Nhật ký
    </a>
</td>

<td>
    <a href="?action=special_request_index&id_book_tour=<?= $schedule->id_book_tour ?>" class="button request-btn">
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
/* Tối ưu toàn diện cho mobile */
@media (max-width: 768px) {

    /* Khoảng cách 2 bên */
    .schedule-container {
        padding: 10px;
    }

    /* Filter xếp 1 cột */
    .filter-container {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        padding: 10px;
    }

    .filter-container input,
    .filter-container select,
    .filter-container button {
        width: 100%;
        font-size: 16px;   /* Tăng kích thước cho dễ bấm */
        padding: 12px;
    }

    /* Bảng cuộn ngang mượt hơn */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .schedule-table {
        min-width: 900px;  /* tránh table bị vỡ layout */
    }

    /* Tăng kích thước select trạng thái */
    .status select {
        padding: 10px;
        font-size: 16px;
    }

    /* Các nút trong bảng */
    .schedule-table a.button {
        padding: 10px;
        font-size: 15px;
        display: inline-block;
        min-width: 90px;
    }
}

/* Giao diện kiểu card cho điện thoại rất nhỏ */
@media (max-width: 480px) {
    .schedule-table th,
    .schedule-table td {
        padding: 8px;
        font-size: 13px;
    }
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
        const statusText = row.cells[5].textContent.toLowerCase();
        const rowStartDate = row.cells[1].textContent; // cột start_date
        const rowEndDate = row.cells[2].textContent;   // cột end_date

        const matchSearch = tourName.includes(searchValue);
const matchStatus = !statusValue || statusText.includes(statusValue === "2" ? "đang hoạt động" : statusValue === "3" ? "đã kết thúc" : "");
        const matchDate = (!startDate || rowStartDate >= startDate) && (!endDate || rowEndDate <= endDate);

        row.style.display = (matchSearch && matchStatus && matchDate) ? '' : 'none';
    });
}

// Event listener
searchInput.addEventListener('input', filterTable);
statusFilter.addEventListener('change', filterTable);
startDateInput.addEventListener('change', filterTable);
endDateInput.addEventListener('change', filterTable);
</script>