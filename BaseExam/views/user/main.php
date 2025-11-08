<!-- Kết nối bootstrap -->
<?php require_once __DIR__ . '/../bootstrap.php'; ?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?></title>

</head>

<body>

    <nav class="navbar navbar-expand-xxl bg-light justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL ?>"><b>Hoàng Như Thuần Đại Đế</b></a>
            </li>
        </ul>
    </nav>

    <table class="table table-bordered text-center align-middle mt-4">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Trạng thái</th>
            <th>ID Tour</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($danhsach as $tt): ?>
            <tr>
                <td><?= $tt->id ?></td>
                <td><?= $tt->name ?></td>
                <td><?= $tt->status ?></td>
                <td><?= $tt->id_tour ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <div class="container">
        <h1 class="mt-3 mb-3"><?= $title ?? 'Home' ?></h1>

        <div class="row">
            <?php
            if (isset($view)) {
                require_once PATH_VIEW . $view . '.php';
            }
            ?>
        </div>
    </div>

</body>

</html>