<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Login_Register_Controller extends Base_Controller{
    function navigation(){
        include 'views/login_register/navigation.php';
    }


    //đăng nhập phía người dùng admin
    function login_user_admin(){
        $err="";
        $lists = $this->userModel->all();
        if(isset($_POST['login_user_admin'])){
            $email       =trim($_POST['email']);
            $password    =trim($_POST['password']);
            $check       = false;

            foreach($lists as $tt){
                if($email === $tt->email){
                    
                    if($tt->status !==1){                  //nếu tài khoản bị khóa sẽ báo lỗi
                        $err = "Tài khoản đã bị khóa";
                        break;
                    }

                    if(password_verify($password, $tt->password)){
                        $check =true;
                        $_SESSION['user']=[
                            'id'   =>$tt->id,
                            'name' =>$tt->name,
                            'role' =>$tt->role,
                        ];


                        if($tt->role ===1){
                            header("Location: ?action=home_admin");
                            exit;
                        }
                        else{
                            header("Location: ?action=home_user");
                            exit;
                        }
                    }
                }
            }
            if(!$check){
                $err ="Kiểm tra lại tài khoàn và mật khẩu của bạn";
            }
            
        }
        include 'views/login_register/login_admin.php';
    }

    

    //đăng nhập phía hướng dẫn viên
    function login_guide(){
        
        include 'views/login_register/login_guide.php';
    }


    //vào thẳng trang web không cần đăng nhập
    function home_user(){
        $danhsach = $this->addressModel->all();
        include 'views/user/home_user.php';
    }

    //đăng ký người dùng
public function guide_registration() {
    $err     ="";
    $success ="";
    $user = new User();
    $usered = $this->userModel->all();

    if(isset($_POST['registration'])) {
        $user->name           = trim($_POST['name']);
        $user->email          = trim($_POST['email']);
        $user->phone_number   = trim($_POST['phone_number']);
        $user->password       = trim($_POST['password']);
        $user->sex            = trim($_POST['sex']);
        $user->role           = 2;            // user
        $user->status         = 1;            // trạng thái
        $user->date           = date('Y-m-d'); // ngày hiện tại

        // Xử lý upload ảnh nếu có
        if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0){
            $user->img = upload_file('imgs', $_FILES["img"]);
        }

        // Kiểm tra email đã tồn tại
        $email_exists = false;
        foreach($usered as $tt){
            if($user->email === $tt->email){
                $email_exists = true;
                break;
            }
        }

        if($email_exists){
            $err = "Email đã được đăng ký";
        }
        else if(empty($user->name) || empty($user->number) || empty($user->password) || empty($user->email)){
            $err = "Kiểm tra lại các trường dữ liệu";
        }
        else{
            // Hash mật khẩu trước khi lưu
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
            $ketqua = $this->userModel->create($user);

            if($ketqua === 1){
                $success = "Đăng ký thành công";
            }
            else{
                $err     = "Đăng ký thất bại";
            }
        }
    }

    include 'views/login_register/guide_registration.php';
}


}
?> 