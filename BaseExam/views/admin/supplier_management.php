<?php require_once 'navbar.php'; ?>

<div class="content-wrapper">
    <h1>QUẢN LÝ NHÀ CUNG CẤP</h1>

    <?php
    // tránh lỗi undefined
    $success = $success ?? "";
    $err     = $err ?? "";
    $errors  = $errors ?? [];
    $servicesBySupplier = $servicesBySupplier ?? [];
    ?>

    <!-- Nút mở popup thêm nhà cung cấp -->
    <div class="mb-3">
        <button type="button"
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#createSupplierModal">
            + Thêm nhà cung cấp
        </button>
    </div>

    <!-- THÔNG BÁO -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($err)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- POPUP (MODAL) THÊM NHÀ CUNG CẤP -->
    <div class="modal fade" id="createSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nhà cung cấp mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên nhà cung cấp</label>
                                    <input type="text" class="form-control" name="name" placeholder="Tên nhà cung cấp...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" placeholder="Địa chỉ...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Người đại diện</label>
                                    <input type="text" class="form-control" name="representative" placeholder="Người đại diện...">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone_number" placeholder="SĐT...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email...">
                                </div>

                                <!-- Chọn nhiều loại dịch vụ cung cấp -->
                                <div class="mb-3">
                                    <label class="form-label">Loại dịch vụ cung cấp</label>

                                    <!-- Container chứa các dòng select -->
                                    <div id="service-container"></div>

                                    <!-- Nút thêm dòng select mới -->
                                    <button type="button"
                                            class="btn btn-outline-secondary btn-sm mt-2"
                                            id="btn-add-service">
                                       
                                    </button>

                                    <?php if (!empty($errors['services'])): ?>
                                        <div class="text-danger small mt-1">
                                            <?= htmlspecialchars($errors['services']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="create" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH NHÀ CUNG CẤP (RÚT GỌN) -->
    <table class="table table-bordered mt-3 align-middle">
        <thead class="table-light">
            <tr>
                <th style="width:60px;">STT</th>
                <th>Tên NCC</th>
                <th>Người đại diện</th>
                <th style="width:130px;">SĐT</th>
                <th style="width:120px;">Trạng thái</th>
                <th style="width:120px;">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php $i = $i ?? 1; ?>
            <?php foreach ($list_supplier as $sp): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($sp->name) ?></td>
                    <td><?= htmlspecialchars($sp->representative) ?></td>
                    <td><?= htmlspecialchars($sp->phone_number) ?></td>
                    <td>
                        <?php if ((int)$sp->status === 1): ?>
                            <span class="btn btn-success">Hoạt động</span>
                        <?php else: ?>
                            <span class="btn btn-danger" style="width:100px;">Ngừng</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Nút mở popup chi tiết -->
                        <button type="button"
                                class="btn btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#detailSupplier<?= $sp->id ?>">
                            Chi tiết
                        </button>
                    </td>
                </tr>

                <!-- MODAL CHI TIẾT + SỬA NHÀ CUNG CẤP CHO TỪNG DÒNG -->
                <div class="modal fade supplier-detail-modal" id="detailSupplier<?= $sp->id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form action="?action=supplier_management&id=<?= $sp->id ?>" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title">Chi tiết nhà cung cấp #<?= $sp->id ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tên nhà cung cấp</label>
                                                <input type="text" name="name"
                                                       class="form-control detail-input"
                                                       value="<?= htmlspecialchars($sp->name) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Địa chỉ</label>
                                                <input type="text" name="address"
                                                       class="form-control detail-input"
                                                       value="<?= htmlspecialchars($sp->address) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Người đại diện</label>
                                                <input type="text" name="representative"
                                                       class="form-control detail-input"
                                                       value="<?= htmlspecialchars($sp->representative) ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Số điện thoại</label>
                                                <input type="text" name="phone_number"
                                                       class="form-control detail-input"
                                                       value="<?= htmlspecialchars($sp->phone_number) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email"
                                                       class="form-control detail-input"
                                                       value="<?= htmlspecialchars($sp->email) ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Trạng thái</label>
                                                <select name="status" class="form-select detail-input">
                                                    <option value="1" <?= $sp->status == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="0" <?= $sp->status == 0 ? 'selected' : '' ?>>Ngừng</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        $services = $servicesBySupplier[$sp->id] ?? [];
                                        $serviceNames = [];
                                        foreach ($services as $sv) {
                                            $serviceNames[] = is_array($sv) ? $sv['type_service'] : $sv->type_service;
                                        }
                                        $serviceText = implode(', ', $serviceNames);
                                    ?>
                                    <div class="mb-3">
                                        <label class="form-label">Dịch vụ cung cấp</label>
                                        <textarea class="form-control" rows="2" readonly><?= htmlspecialchars($serviceText) ?></textarea>
                                        <div class="form-text">Hiện tại chưa thể chỉnh sửa dịch vụ.</div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Đóng
                                    </button>
                                    <button type="button" class="btn btn-primary btn-toggle-edit" data-mode="view">
                                        Sửa
                                    </button>
                                    <input type="hidden" name="update" value="1">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// ========== FORM THÊM: LOGIC CHỌN NHIỀU DỊCH VỤ ==========
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('service-container');
    const btnAdd    = document.getElementById('btn-add-service');
    const MAX_ROWS  = 7;  // 3 cố định + tối đa 4 "dịch vụ khác"

    if (container && btnAdd) {

        function createServiceRow(isFirst = false) {
            const row = document.createElement('div');
            row.className = 'service-row mb-2';

            row.innerHTML = `
                <select name="services[]" class="form-select service-select mb-1">
                    <option value="">${isFirst ? 'Chọn dịch vụ' : 'Chọn thêm dịch vụ'}</option>
                    <option value="xe"         data-fixed="1">Nhà xe</option>
                    <option value="nha_hang"   data-fixed="1">Nhà hàng</option>
                    <option value="khach_san"  data-fixed="1">Khách sạn</option>
                    <option value="other">Dịch vụ khác</option>
                </select>
                <input type="text"
                       name="services_other[]"
                       class="form-control service-other-input"
                       placeholder="Nhập tên dịch vụ khác..."
                       style="display:none;">
            `;

            container.appendChild(row);

            const select = row.querySelector('.service-select');
            select.addEventListener('change', refreshServiceOptions);

            refreshServiceOptions();
        }

        function getStats() {
            const selects = container.querySelectorAll('.service-select');
            const usedFixed = new Set();
            let otherCount = 0;

            selects.forEach(sel => {
                const val = sel.value;
                if (val === 'xe' || val === 'nha_hang' || val === 'khach_san') {
                    usedFixed.add(val);
                }
                if (val === 'other') {
                    otherCount++;
                }
            });

            return { selects, usedFixed, otherCount };
        }

        function refreshServiceOptions() {
            const { selects, usedFixed, otherCount } = getStats();

            selects.forEach(sel => {
                const opts = sel.options;
                const val  = sel.value;

                for (let i = 0; i < opts.length; i++) {
                    const opt = opts[i];
                    const v   = opt.value;

                    if (v === 'xe' || v === 'nha_hang' || v === 'khach_san') {
                        if (val === v) {
                            opt.disabled = false;
                        } else {
                            opt.disabled = usedFixed.has(v);
                        }
                    }

                    if (v === 'other') {
                        if (val === 'other') {
                            opt.disabled = false;
                        } else {
                            opt.disabled = (otherCount >= 4);
                        }
                    }
                }

                const inputOther = sel.parentElement.querySelector('.service-other-input');
                if (val === 'other') {
                    inputOther.style.display = '';
                } else {
                    inputOther.style.display = 'none';
                    inputOther.value = '';
                }
            });

            updateAddButtonState();
        }

        function updateAddButtonState() {
            const rows = container.querySelectorAll('.service-row').length;
            btnAdd.disabled = (rows >= MAX_ROWS);
        }

        btnAdd.addEventListener('click', function(e) {
            e.preventDefault();
            const rows = container.querySelectorAll('.service-row').length;
            if (rows < MAX_ROWS) {
                createServiceRow(false);
            }
            updateAddButtonState();
        });

        // Tạo sẵn 1 dòng ban đầu
        createServiceRow(true);
    }

    // ========== MODAL CHI TIẾT + SỬA: BẬT/TẮT EDIT + CẢNH BÁO MẤT DỮ LIỆU ==========
    const detailModals = document.querySelectorAll('.supplier-detail-modal');

    detailModals.forEach(modalEl => {
        const form   = modalEl.querySelector('form');
        const btnEdit = modalEl.querySelector('.btn-toggle-edit');
        if (!form || !btnEdit) return;

        // luôn vào trạng thái xem trước
        setReadOnly(modalEl, true);
        btnEdit.dataset.mode = 'view';

        btnEdit.addEventListener('click', function(e) {
            e.preventDefault();
            const mode = this.dataset.mode || 'view';

            if (mode === 'view') {
                // chuyển sang chế độ sửa
                const snapshot = JSON.stringify(getFormDataObj(form));
                this.dataset.initial = snapshot;

                setReadOnly(modalEl, false);
                this.textContent = 'Lưu';
                this.dataset.mode = 'edit';
            } else if (mode === 'edit') {
                // bấm Lưu -> submit form
                form.submit();
            }
        });

        // Cảnh báo khi đóng modal nếu đang sửa và có thay đổi
        modalEl.addEventListener('hide.bs.modal', function(event) {
            const mode = btnEdit.dataset.mode || 'view';
            if (mode !== 'edit') {
                // không ở chế độ sửa thì reset UI sau khi ẩn
                modalEl.dataset.resetOnHide = '1';
                return;
            }

            const initial = btnEdit.dataset.initial || '';
            if (!initial) {
                modalEl.dataset.resetOnHide = '1';
                return;
            }

            const current = JSON.stringify(getFormDataObj(form));
            if (current === initial) {
                // không có thay đổi
                modalEl.dataset.resetOnHide = '1';
                return;
            }

            const confirmClose = window.confirm('Bạn có thay đổi chưa lưu. Đóng cửa sổ mà không lưu?');
            if (!confirmClose) {
                event.preventDefault();
            } else {
                // cho phép đóng nhưng reset lại dữ liệu
                modalEl.dataset.resetOnHide = '1';
            }
        });

        modalEl.addEventListener('hidden.bs.modal', function() {
            if (modalEl.dataset.resetOnHide) {
                resetModalView(modalEl, form, btnEdit);
                delete modalEl.dataset.resetOnHide;
            }
        });
    });

    function setReadOnly(modalEl, isReadOnly) {
        const inputs = modalEl.querySelectorAll('.detail-input');
        inputs.forEach(el => {
            if (el.tagName === 'SELECT') {
                el.disabled = isReadOnly;
            } else {
                el.readOnly = isReadOnly;
            }
        });
    }

    function getFormDataObj(form) {
        const fd = new FormData(form);
        const obj = {};
        fd.forEach((value, key) => {
            obj[key] = value;
        });
        return obj;
    }

    function resetModalView(modalEl, form, btnEdit) {
        const initial = btnEdit.dataset.initial || '';
        if (initial) {
            try {
                const data = JSON.parse(initial);
                Object.keys(data).forEach(key => {
                    if (form.elements[key]) {
                        form.elements[key].value = data[key];
                    }
                });
            } catch (e) {
                console.error('Không parse được snapshot form:', e);
            }
            btnEdit.dataset.initial = '';
        }

        setReadOnly(modalEl, true);
        btnEdit.textContent = 'Sửa';
        btnEdit.dataset.mode = 'view';
    }
});
</script>
