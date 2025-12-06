<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tour</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .tour-container {
            display: flex;
            flex-wrap: wrap; /* cho phép xuống dòng */
            gap: 20px;       /* khoảng cách giữa các tour */
            justify-content: center;
        }

        .tour {
            border: 1px solid #ccc;
            padding: 10px;
            width: calc(33.333% - 20px); /* 3 tour trên 1 hàng */
            box-sizing: border-box;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: transform 0.2s;
        }

        .tour:hover {
            transform: scale(1.03);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .tour img {
            max-width: 100%;
            display: block;
            margin-bottom: 5px;
            border-radius: 3px;
        }

        .images {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
        }

        .images img {
            width: 48%; /* 2 ảnh mỗi dòng, có thể chỉnh */
            object-fit: cover;
        }

        @media (max-width: 900px) {
            .tour {
                width: calc(50% - 20px); /* 2 tour trên 1 hàng */
            }
        }

        @media (max-width: 600px) {
            .tour {
                width: 100%; /* 1 tour trên 1 hàng */
            }
        }
    </style>
</head>
<body>
    <h1>Danh sách Tour</h1>

    <div class="tour-container">
        <?php if(!empty($tours)): ?> 
            <?php foreach($tours as $tour): ?>
                <div class="tour">
                    <a href="?action=guide_booktour_detail&id=<?= $tour['id'] ?>" style="text-decoration:none; color: inherit;">
                    <h2><?= htmlspecialchars($tour['name']) ?></h2>
                    <p>Loại tour: <?= htmlspecialchars($tour['tour_type_name']) ?></p>
                    <p>Chặng: <?= !empty($tour['route']) ? htmlspecialchars($tour['route']) : 'Chưa có chặng' ?></p>
                    <p>Số ngày: <?= htmlspecialchars($tour['number_of_days'] ?? '-') ?> | Số đêm: <?= htmlspecialchars($tour['number_of_nights'] ?? '-') ?></p>
                    <p>Giá: <?= number_format($tour['price']/$tour['scope']*1.05, 0, ',', '.') ?> VND/người</p>
                    <?php if(!empty($tour['images'])): ?>
                        <div class="images">
                            <?php
                            $images = explode('|', $tour['images']);
                            foreach($images as $img):
                            ?>
                                <img src="<?=BASE_URL .htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($tour['name']) ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có tour nào.</p>
        <?php endif; ?>
    </div>

</body>
</html>
