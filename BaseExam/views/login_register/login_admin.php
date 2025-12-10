<?php require_once 'views/bootstrap.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  /* Nền tổng thể */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #74ABE2, #5563DE);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Khung form */
form {
    background-color: #fff;
    padding: 40px 60px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    width: 350px;
}

/* Tiêu đề */
form h4 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
    color: #333;
}

/* Label */
form label {
    font-weight: 500;
    color: #444;
    margin-bottom: 5px;
    display: block;
}

/* Input */
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    transition: 0.3s ease;
}

/* Hiệu ứng focus */
form input:focus {
    border-color: #5563DE;
    box-shadow: 0 0 5px rgba(85, 99, 222, 0.5);
    outline: none;
}

/* Nút đăng nhập */
form button {
    width: 100%;
    padding: 10px;
    background-color: #5563DE;
    border: none;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    transition: 0.3s ease;
}

form button:hover {
    background-color: #3e4bbf;
}

/* Link đăng ký */
form a {
    display: block;
    text-align: center;
    margin-top: 15px;
    text-decoration: none;
    color: #5563DE;
    font-weight: 500;
}

form a:hover {
    text-decoration: underline;
}

/* Lỗi */
span {
    display: block;
    text-align: center;
    margin-bottom: 10px;
    color: red;
    font-size: 14px;
}

    </style>
</head>
<body>
    <form method="post" id="loginForm">
    <h4 style="text-align:center;">Đăng nhập</h2>
  <div class="row mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="email">
    <span id="" style="color:red;"><?=$err_email?></span>

  </div>
  <div class="row mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    <span id="" style="color:red;"><<?=$err_password?>/span>
  </div>


  </div>
      <!-- Hiển thị lỗi PHP -->
<span style="color:red; display:block; text-align:center;">
    <?= isset($err) ? $err : '' ?>
</span>
  <button type="submit" class="btn btn-primary" name="login_user_admin">Đăng nhập</button>
  <a href="?action=guide_registration">Đăng ký</a>
</form>

<!-- <script>
  
    document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();

    //khai báo biến giá trị
    let email = document.getElementById("exampleInputEmail1").value.trim();
    let password = document.getElementById("exampleInputPassword1").value.trim();

    // Xóa thông báo lỗi
    document.getElementById("err_email").innerHTML = "";
    document.getElementById("err_password").innerHTML = "";

    // khai báo biến kiểm tra
    let check = true;
    if(email == ""){
        document.getElementById("err_email").innerHTML = "Không được bỏ trống";
        check = false;
    }else if(email.length <3 || email.length > 30){
        document.getElementById("err_email").innerHTML = "Độ dài của username phải nằm trong khoảng 3 đến 30 ký tự";
        check = false;
    }

    if(password == ""){
        document.getElementById("err_password").innerHTML = "Không được bỏ trống";
        check = false;
    }else if(password.length <6 || password.length > 10){
        document.getElementById("err_password").innerHTML = "Độ dài của password phải nằm trong khoảng 6 đến 10 ký tự";
        check = false;
    }

    if(check){
        this.submit(); // gửi form lên PHP khi mọi thứ hợp lệ
    }

})

</script> -->
</body>
</html>