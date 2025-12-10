<?php require_once 'Base_Controller.php'; 

// kế thừa từ BaseController
class Admin_Controller extends Base_Controller{
    function __construct(){
        parent::__construct();  

        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
            header("Location: ?action=login_admin");
            exit;
        }

        if ((int)$_SESSION['user']['role'] !== 1) {
            header("Location: ?action=home_user");
            exit;
        }
    } 

    function home_admin(){                       //trang home admin
        $total_amount    = $this->payModel->get_total_amount();
        $status_1 = 1;
        $status_2 = 2;
        $status_3 = 3;
        $total_book_tour_1 =$this->booktourModel->getTotalToursStatus($status_1);
        $total_book_tour_2 =$this->booktourModel->getTotalToursStatus($status_2);
        $total_book_tour_3 =$this->booktourModel->getTotalToursStatus($status_3);

        $payModel = new Pay_Model();
        $revenue = $payModel->getRevenueByMonth(); // dữ liệu năm hiện tại

        $labels = json_encode($revenue['labels']);
        $data   = json_encode($revenue['data']);

        include 'views/admin/home_admin.php';
    }

    //========================   quản lý danh mục tour   ===============================

    function tour_catalog_management(){          
        $list_tour_type = $this->tourtypeModel->all();
        $i =1;
        $success ="";
        $err     ="";
        $tour_type = new Tour_type;
        if(isset($_POST['create'])){
            $tour_type->tour_type_name = $_POST['name'];
            $tour_type->date           = date("Y-m-d");

            if($tour_type->tour_type_name !==""){
                $data = $this->tourtypeModel->create($tour_type);
                if($data === 1){
                    header("Location:?action=tour_catalog_management&msg=success");
                    exit;
                }else{
                    header("Location:?action=tour_catalog_management&msg=error");
                    exit;
                }
            }
            else{
                $err ="bạn chưa điền dữ liệu !";
            }
            $list_tour_type = $this->tourtypeModel->all();
        }
        include 'views/admin/tour_catalog_management.php';
    }

    function delete_tour_tour($id){                     //xóa danh mục tour
        $success ="";
        $err     ="";
        $result =$this ->tourtypeModel->delete_tour_tour($id);
        if($result ===1){
            header("Location: ?action=tour_catalog_management&msg=success");
        }
        else{
            header("Location: ?action=tour_catalog_management&msg=error");
        }
        exit;
        include 'views/admin/tour_catalog_management.php';
    }
 
    function update_tour_type($id) {                      // Cập nhật tour
        $tour_type = $this->tourtypeModel->find_tour_type($id);                 
        if (isset($_POST['update'])) {   // kiểm tra button submit
        $tour_type->id = $id;
        $tour_type->tour_type_name = $_POST['tour_type_name']; // Lấy đúng giá trị từ input
        $tour_type->date = date("Y-m-d"); 

        $result = $this->tourtypeModel->update_tour_type($tour_type);

        if ($result === 1) {
            header("Location: ?action=tour_catalog_management&msg=success");
        } else {
            header("Location: ?action=tour_catalog_management&msg=error");
        }
        exit;
    }
    }

    //===========================   quản lý hướng dẫn viên   ===================================

    function human_resource_management(){
    $notification = "";             
    $sql = "SELECT * FROM `tour_guide` WHERE 1"; // Mặc định lấy tất cả
    $list_languages =$this->tourguideModel->get_languages_unique();

    // Lọc theo ngôn ngữ nếu có
    if(isset($_GET['foreign_languages']) && $_GET['foreign_languages'] != ""){
        $language = addslashes($_GET['foreign_languages']); // tránh lỗi SQL
        $sql .= " AND `foreign_languages` = '$language'";
    }

    // Nếu muốn lọc theo khu vực, chỉ bật khi có param type_guide
    if(isset($_GET['type_guide']) && $_GET['type_guide'] != ""){
        $type = intval($_GET['type_guide']);
        $sql .= " AND type_guide = $type";
    }


    $list = $this->tourguideModel->filter_tour_guide($sql);

    if(empty($list)){
        $notification = "Không có nhân sự nào";
    }

    include 'views/admin/human_resource_management.php';
}

    function change_status_tour_guide($id){
        $tour_guide =$this->tourguideModel->find_tour_guide($id);
        $value =$tour_guide->status;
        if($value === 1){
            $value = 2;
        }
        else{
            $value = 1;
        }
        $result = $this->tourguideModel->change_status_tour_guide($tour_guide, $value);
        header("Location: ?action=human_resource_management");
        exit;
        include 'views/admin/human_resource_management.php';
    }


    function search_tour_guide(){
        // Xử lý tìm kiếm
        $result=[];
        $notification="";
        $list = $this->tourguideModel->all();
        if(isset($_GET['search_tour_guide'])){
            $key_word = trim($_GET['key_word']);
            if($key_word === ""){
                $notification = "Bạn chưa nhập dữ liệu";
            } else {
                $result = [];
                foreach($list as $tt){
                    if(stripos($tt->name, $key_word) !== false || stripos($tt->email, $key_word) !== false){
                        $result[] = $tt;
                    }
                }

                if(empty($result)){
                    $notification = "Không tìm thấy kết quả";
                } else {
                    $list = $result; // gán kết quả tìm được
                }
            }
        }
        include 'views/admin/human_resource_management.php';
    }
    
    function update_tour_guide($id){
        $succsee ="";
        $er      ="";
        $list =$this->tourguideModel->all();
        $tour_guide =$this->tourguideModel->find_tour_guide($id);
        if(isset($_POST['update_tour_guide'])){
            $tour_guide->id = $id;
            $tour_guide->name               = $_POST['name'];
            $tour_guide->email              = $_POST['email'];
            $tour_guide->phone_number       = $_POST['phone_number'];
            $tour_guide->type_guide         = $_POST['type_guide'];
            $tour_guide->foreign_languages  = $_POST['foreign_languages'];
            $tour_guide->years_experience   = $_POST['years_experience'];
            $tour_guide->sex                = $_POST['sex'];
            $tour_guide->health             = $_POST['health'];
            $tour_guide->year_birth         = $_POST['year_birth'];

            if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0){        //file ảnh đại diện
                $tour_guide->img = upload_file('imgs', $_FILES["img"]);
            }

            if(isset($_FILES["certificate"]) && $_FILES["certificate"]["size"] > 0){         //file giấy chứng nhận
                $tour_guide->certificate = upload_file('imgs', $_FILES["certificate"]);
            }

            if( $tour_guide->name !=="" &&  
                $tour_guide->email !=="" && 
                $tour_guide->phone_number !=="" && 
                $tour_guide->type_guide !=="" &&
                $tour_guide->foreign_languages !=="" && 
                $tour_guide->years_experience !=="" && 
                $tour_guide->sex !=="" && 
                $tour_guide->health !=="" &&
                $tour_guide->year_birth !=="" && 
                $tour_guide->img !=="" && 
                $tour_guide->certificate !=="" ){
                $result = $this->tourguideModel->update_tour_guide($tour_guide);
                    if ($result === 1) {
                        header("Location: ?action=human_resource_management&msg=success");
                        exit;
                    } else {
                    header("Location: ?action=human_resource_management&msg=error");
                    exit;
                }

            }
        }
        include 'views/admin/human_resource_management.php';

    }

    function add_tour_guide(){                                    //thêm thướng dẫn viên
        $tour_guide =new Tour_guide;
        if(isset($_POST['create_tour_guide'])){
            $tour_guide->name               = $_POST['name'];
            $tour_guide->email              = $_POST['email'];
            $tour_guide->phone_number       = $_POST['phone_number'];
            $tour_guide->type_guide         = $_POST['type_guide'];
            $tour_guide->foreign_languages  = $_POST['foreign_languages'];
            $tour_guide->years_experience   = $_POST['years_experience'];
            $tour_guide->sex                = $_POST['sex'];
            $tour_guide->health             = $_POST['health'];
            $tour_guide->year_birth         = $_POST['year_birth'];
            $tour_guide->status             = 1;
            $tour_guide->password           = $_POST['password'];

            if(isset($_FILES["img"]) && $_FILES["img"]["size"] > 0){        //file ảnh đại diện
                $tour_guide->img = upload_file('imgs', $_FILES["img"]);
            }

            if(isset($_FILES["certificate"]) && $_FILES["certificate"]["size"] > 0){         //file giấy chứng nhận
                $tour_guide->certificate = upload_file('imgs', $_FILES["certificate"]);
            }

            if( $tour_guide->name !=="" &&
              $tour_guide->email !=="" && 
              $tour_guide->phone_number !=="" && 
              $tour_guide->type_guide !=="" &&
              $tour_guide->years_experience !=="" && 
              $tour_guide->sex !=="" && 
              $tour_guide->img !=="" && 
              $tour_guide->health !=="" && 
              $tour_guide->year_birth !=="" && 
              $tour_guide->certificate !=="" && 
              $tour_guide->foreign_languages !== "" &&
              $tour_guide->password !==""){
                    $tour_guide->password = password_hash($tour_guide->password, PASSWORD_DEFAULT);      //mã hóa mật khẩu
                    $result = $this->tourguideModel->create_tour_guide($tour_guide);
                        if ($result === 1) {
                            header("Location: ?action=human_resource_management&msg=success");
                            exit;
                        } else {
                            header("Location: ?action=human_resource_management&msg=error");
                            exit;
                    }

                }
        }
        include 'views/admin/human_resource_management.php';
        }

    function logout_admin(){
        session_start();        // chắc chắn session đã bắt đầu
        session_unset();        // xóa tất cả biến session
        session_destroy();      // hủy session

        // xóa cookie session (nếu có)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header("Location: ?action=login_admin");  // chuyển về trang login
        exit();
    }




function supplier_management() {
        $supplierModel     = new Supplier_Model();
        $tourSupplierModel = new Tour_supplier_Model();                          // dùng để lưu + đọc dịch vụ nhà cung cấp

        // lấy danh sách hiện tại
        $list_supplier = $supplierModel->all();
        $success = "";
        $err     = "";
        $errors  = [];   // mảng lỗi chi tiết
        $i       = 1;

        // ====== THÊM NHÀ CUNG CẤP ======
        if (isset($_POST['create'])) {
            $supplier = new supplier();
            $supplier->name           = trim($_POST['name'] ?? '');
            $supplier->address        = trim($_POST['address'] ?? '');
            $supplier->representative = trim($_POST['representative'] ?? '');
            $supplier->phone_number   = trim($_POST['phone_number'] ?? '');
            $supplier->email          = trim($_POST['email'] ?? '');

            $supplier->status         = 1;      // mặc định đang hoạt động
            $supplier->note           = '';     // tránh null

            // ================= VALIDATE cơ bản =================
            if ($supplier->name === '') {
                $errors['name'] = "Vui lòng nhập tên nhà cung cấp.";
            }

            if ($supplier->representative === '') {
                $errors['representative'] = "Vui lòng nhập tên người đại diện.";
            } elseif (!preg_match('/^[\p{L}\s]+$/u', $supplier->representative)) {
                $errors['representative'] = "Tên người đại diện chỉ được chứa chữ và khoảng trắng.";
            }

            if ($supplier->phone_number === '') {
                $errors['phone_number'] = "Vui lòng nhập số điện thoại.";
            } elseif (!preg_match('/^[0-9]{8,12}$/', $supplier->phone_number)) {
                $errors['phone_number'] = "Số điện thoại phải là 8–12 chữ số.";
            }

            if ($supplier->email === '') {
                $errors['email'] = "Vui lòng nhập email.";
            } elseif (!preg_match('/^[A-Za-z0-9._%+-]+@gmail\.com$/', $supplier->email)) {
                $errors['email'] = "Email phải có dạng ten@gmail.com.";
            }

            // ================= XỬ LÝ DỊCH VỤ (khi thêm NCC) =================
            // Đọc từ form động: services[] + services_other[]
            $servicesSelect = isset($_POST['services']) ? (array)$_POST['services'] : [];
            $servicesOther  = isset($_POST['services_other']) ? (array)$_POST['services_other'] : [];
            $finalServices  = [];

            foreach ($servicesSelect as $idx => $code) {
                $code = trim($code);
                if ($code === '') continue; // bỏ dòng chưa chọn gì

                $label = '';

                // 3 loại cố định
                if ($code === 'xe') {
                    $label = 'Nhà xe';
                } elseif ($code === 'nha_hang') {
                    $label = 'Nhà hàng';
                } elseif ($code === 'khach_san') {
                    $label = 'Khách sạn';
                }
                // Dịch vụ khác → lấy text tương ứng
                elseif ($code === 'other') {
                    $otherName = isset($servicesOther[$idx]) ? trim($servicesOther[$idx]) : '';
                    if ($otherName === '') {
                        // chọn "Dịch vụ khác" mà không nhập gì thì bỏ qua
                        continue;
                    }
                    $label = $otherName;
                }

                if ($label !== '' && !in_array($label, $finalServices, true)) {
                    $finalServices[] = $label;
                }
            }

            if (empty($finalServices)) {
                $errors['services'] = "Vui lòng chọn/nhập ít nhất một dịch vụ.";
            }

            // tối đa 7 dịch vụ (3 cố định + 4 tự do)
            if (count($finalServices) > 7) {
                $finalServices = array_slice($finalServices, 0, 7);
            }

            // ================= INSERT NCC + DỊCH VỤ =================
            if (empty($errors)) {
                $supplier_id = $supplierModel->create($supplier); // trả về id mới
                if ($supplier_id > 0) {
                    if (!empty($finalServices)) {
                        $tourSupplierModel->createForSupplier($supplier_id, $finalServices);
                    }

                    $success       = "Thêm nhà cung cấp thành công!";
                    $list_supplier = $supplierModel->all();   // load lại list
                } else {
                    $err = "Thêm thất bại, vui lòng thử lại.";
                }
            } else {
                $err = "Dữ liệu không hợp lệ, vui lòng kiểm tra lại.";
            }
        }

        // ====== XỬ LÝ CẬP NHẬT (TỪ POPUP CHI TIẾT/SỬA) ======
        if (isset($_POST['update']) && isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $supplier = $supplierModel->find($id);
            if ($supplier) {
                $supplier->name           = trim($_POST['name'] ?? '');
                $supplier->address        = trim($_POST['address'] ?? '');
                $supplier->representative = trim($_POST['representative'] ?? '');
                $supplier->phone_number   = trim($_POST['phone_number'] ?? '');
                $supplier->email          = trim($_POST['email'] ?? '');
                $supplier->status         = isset($_POST['status']) ? (int)$_POST['status'] : $supplier->status;

                $errors = [];

                if ($supplier->name === '') {
                    $errors['name'] = "Vui lòng nhập tên nhà cung cấp.";
                }

                if ($supplier->representative === '') {
                    $errors['representative'] = "Vui lòng nhập tên người đại diện.";
                } elseif (!preg_match('/^[\p{L}\s]+$/u', $supplier->representative)) {
                    $errors['representative'] = "Tên người đại diện chỉ được chứa chữ và khoảng trắng.";
                }

                if ($supplier->phone_number === '') {
                    $errors['phone_number'] = "Vui lòng nhập số điện thoại.";
                } elseif (!preg_match('/^[0-9]{8,12}$/', $supplier->phone_number)) {
                    $errors['phone_number'] = "Số điện thoại phải là 8–12 chữ số.";
                }

                if ($supplier->email === '') {
                    $errors['email'] = "Vui lòng nhập email.";
                } elseif (!preg_match('/^[A-Za-z0-9._%+-]+@gmail\.com$/', $supplier->email)) {
                    $errors['email'] = "Email phải có dạng ten@gmail.com.";
                }

                if (empty($errors)) {
                    $result = $supplierModel->update($supplier);
                    if ($result === 1 || $result === 0) { // rowCount có thể trả 0 nếu không đổi gì
                        $success       = "Cập nhật nhà cung cấp thành công!";
                        $list_supplier = $supplierModel->all();
                    } else {
                        $err = "Cập nhật thất bại, vui lòng thử lại.";
                    }
                } else {
                    $err = "Dữ liệu không hợp lệ, vui lòng kiểm tra lại.";
                }
            } else {
                $err = "Không tìm thấy nhà cung cấp.";
            }
        }

        // ====== LOAD DỊCH VỤ CHO TỪNG NCC ĐỂ ĐỔ RA VIEW CHI TIẾT ======
        $servicesBySupplier = [];
        foreach ($list_supplier as $sp) {
            $servicesBySupplier[$sp->id] = $tourSupplierModel->getBySupplier($sp->id);
        }

        include 'views/admin/supplier_management.php'; //gọi view
    }

    function edit_supplier($id) {
        // không dùng view riêng, luôn quay lại danh sách
        header("Location: ?action=supplier_management");
        exit;
    }


    function getUserById(){
        $id = 10;
        $user = $this->userModel->getUserById($id);
        include 'views/admin/navabr.php'; //gọi view
    }
    
}
 







