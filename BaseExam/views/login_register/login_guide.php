<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hướng dẫn viên</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .err {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }

        input[type="email"],
        input[type="password"]{
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #aaa;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0099ff;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0077cc;
        }

    </style>
</head>
<body>

<div class="form-container">
    <h2>Đăng nhập hướng dẫn viên</h2>

    <?php if (!empty($err)): ?>
        <div class="err"><?= $err ?></div>
    <?php endif; ?>

<form action="?action=guide_login" method="POST">
    <input type="email" name="email" placeholder="Nhập email" required>
    <input type="password" name="password" placeholder="Nhập mật khẩu" required>

    <button type="submit" name="login_guide">Đăng nhập</button>

    <?php if (!empty($err)) : ?>
        <p style="color:red"><?= $err ?></p>
    <?php endif; ?>
</form>

</div>

</body>
</html>
