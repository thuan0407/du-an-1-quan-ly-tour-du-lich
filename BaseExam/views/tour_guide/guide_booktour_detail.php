<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <h2>Thông tin tour</h2>
        <h4><?= htmlspecialchars($tour['name']) ?></h4>
        <p><b>Loại tour:</b> <?= htmlspecialchars($tour['tour_type_name'] ?? '-') ?></p>
        <p><b>Lộ trình:</b> <?= htmlspecialchars($tour['route'] ?? '-') ?></p>
        <p><b>Số ngày/đêm:</b> <?= htmlspecialchars($tour['number_of_days'] ?? '-') ?> ngày | <?= htmlspecialchars($tour['number_of_nights'] ?? '-') ?> đêm</p>
        <p><b>Mô tả:</b> <?= nl2br(htmlspecialchars($tour['describe'] ?? '-')) ?></p>
        <p><b>Giá:</b> <?= number_format($tour['price']/$tour['qt']*1.05 ?? 0) ?> VND/người</p>

        <hr>

        <h3>Thông tin khách đặt tour</h3>

        <form action="?action=guide_booktour" method="post" id="bookingForm">

            <!-- Thông tin tour cơ bản -->
            <input type="hidden" name="id_tour" value="<?= $tour['id'] ?>">
            <input type="hidden" name="number_of_days" value="<?= $tour['number_of_days'] ?>">
            <input type="hidden" name="number_of_nights" value="<?= $tour['number_of_nights'] ?>">
            <input type="hidden" name="total_amount" id="total_amount_input" value="<?= $tour['price']/$tour['qt']*1.05 ?>">

            <!-- Cho phép chỉnh số ngày / số đêm -->


            <label>Tên khách:</label>
            <input type="text" name="customername" required>

            <label>Số điện thoại:</label>
            <input type="text" name="phone" id="phone" required>

            
            <input type="hidden" name="date" value="<?= date('Y-m-d') ?>" required>

            <label>Ghi chú (ngày muốn đi):</label>
            <input type="text" name="note">

            <label>Số lượng khách:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" required>

            <label>Tổng tiền tạm tính:</label>
            <input type="text" id="total_amount_display" value="<?= number_format($tour['price']/$tour['qt']*1.05, 0, ',', '.') ?> VND" disabled>

            <button type="submit">Đặt tour</button>
        </form>

        <script>
        const quantityInput = document.getElementById('quantity');
        const totalDisplay = document.getElementById('total_amount_display');
        const totalInput = document.getElementById('total_amount_input');
        const phoneInput = document.getElementById('phone');
        const daysInput = document.getElementById('number_of_days');
        const nightsInput = document.getElementById('number_of_nights');
        const form = document.getElementById('bookingForm');

        // Giá 1 người
        const pricePerPerson = <?= $tour['price']/$tour['qt']*1.05 ?>;

        // Cập nhật tổng tiền khi quantity thay đổi
        quantityInput.addEventListener('input', updateTotal);
        daysInput.addEventListener('input', updateTotal);

        function updateTotal() {
            const qty = parseInt(quantityInput.value) || 0;
            const total = pricePerPerson * qty;
            totalDisplay.value = total.toLocaleString('vi-VN') + " VND";
            totalInput.value = total;
        }

        // Validation trước khi submit
        form.addEventListener('submit', function(e) {
            const phone = phoneInput.value.trim();
            const days = parseInt(daysInput.value);
            const nights = parseInt(nightsInput.value);

            // Kiểm tra số điện thoại 10 số
            if (!/^\d{10}$/.test(phone)) {
                alert("Số điện thoại không hợp lệ");
                e.preventDefault();
                return;
            }

            // Kiểm tra số đêm
            if (nights !== days && nights !== days - 1) {
                alert("Số ngày đêm không hợp lệ");
                e.preventDefault();
                return;
            }
        });
        </script>
        <style>
            /* Toàn trang */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* Tiêu đề */
        h2, h3, h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 15px 0;
        }

        /* Form */
        form#bookingForm {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        /* Label */
        form#bookingForm label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        /* Input */
        form#bookingForm input[type="text"],
        form#bookingForm input[type="number"],
        form#bookingForm input[type="date"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        /* Disabled input */
        form#bookingForm input[disabled] {
            background-color: #e9ecef;
            color: #495057;
        }

        /* Button */
        form#bookingForm button[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form#bookingForm button[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Responsive */
        @media (max-width: 640px) {
            form#bookingForm {
                padding: 15px;
            }
        }

        </style>
    
</body>
</html>
