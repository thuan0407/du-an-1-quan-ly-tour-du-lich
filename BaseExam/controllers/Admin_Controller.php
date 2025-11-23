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

    // Lọc theo ngôn ngữ nếu có
    if(isset($_GET['foreign_languages']) && $_GET['foreign_languages'] != ""){
        $language = addslashes($_GET['foreign_languages']); // tránh lỗi SQL
        $sql .= " AND `foreign_languages` = '$language'";
    }

    // Nếu muốn lọc theo khu vực, chỉ bật khi có param type_guide
    if(isset($_GET['type_guide']) && $_GET['type_guide'] != ""){
        $type = strtolower($_GET['type_guide']);
        if($type === 'nội địa' || $type === 'ngoại địa'){
            $sql .= " AND LOWER(type_guide) = '$type'";
        }
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



//=============================        quản lý tour        ===============================================

    function tour_manager_content(){
        $notification="";     //thông báo lỗi  

        $selectedType = $_GET['tour_type_name'] ?? '';                                     //bộ lọc theo loại tour    
        if($selectedType){
            $list = $this->tourModel->getToursByType($selectedType);
        } else {
            $list = $this->tourModel->all();
        }

        $price = $_GET['price'] ?? '';
            if ($price == 1){
                $list = $this->tourModel->getToursHigh();   // GIÁ CAO → THẤP
            }
            elseif ($price == 2){
                $list = $this->tourModel->getToursShort();  // GIÁ THẤP → CAO
            }


        // $list = $this-> tourModel->all();
        $list_tour_type = $this->tourtypeModel->all();
        $list_tour_supplier = $this-> toursupplierModel->all();

        // Lấy tất cả id_tour đã có booking
         $bookedTours = $this->booktourModel->getidbooking();
        
        include 'views/admin/tour_manager/tour_manager_content.php';
    }

    public function add_tour() {                                                      //Tạo tour mới
    $list_type_tour = $this->tourtypeModel->all();
    $list_toursupplier = $this->toursupplierModel->all();
    $success = "";

    if(isset($_POST['create'])){ 
        // 1. Tạo đối tượng Tour
        $tour = new Tour();
        $tour->name             = trim($_POST['name'] ?? '');
        $tour->price            = floatval($_POST['price'] ?? 0);
        $tour->number_of_days       = intval($_POST['number_of_days'] ?? 0);
        $tour->number_of_nights = intval($_POST['number_of_nights'] ?? 0);
        $tour->scope            = intval($_POST['scope'] ?? 0);
        $tour->describe         = trim($_POST['describe'] ?? '');
        $tour->status           = 1;
        $tour->date             = date("Y-m-d");
        $tour->id_tourtype      = $_POST['id_tourtype'] ?? null;
        $tour->type_tour        = $_POST['type_tour'] ?? 1;

        // 2. Lưu tour vào DB
        $tour_id = $this->tourModel->insert($tour);

        if($tour_id > 0){
            // 3. Lưu ảnh tour
            if(!empty($_FILES['images']['name'])){
                foreach($_FILES['images']['name'] as $key => $name){
                    if($_FILES['images']['error'][$key] === 0){
                        $tmp_name = $_FILES['images']['tmp_name'][$key];
                        $unique_name = time() . "_" . $name;
                        $path = "uploads/tour/$unique_name";
                        move_uploaded_file($tmp_name, $path);
                        $this->imgtourModel->insert([
                            'tour_id'    => $tour_id,
                            'image_path' => $path
                        ]);
                    }
                }
            }

            // 4. Lưu địa điểm
            if(!empty($_POST['address'])){
                $addresses = array_unique(array_map('trim', $_POST['address']));
                foreach($addresses as $addr){
                    if($addr !== ""){
                        $this->addressModel->insert([
                            'id_tour' => $tour_id,
                            'name'    => $addr,
                            'status'  => 1
                        ]);
                    }
                }
            }

            // 5. Lưu chính sách
            if(!empty($_FILES['content']['name'])){
                foreach($_FILES['content']['name'] as $key => $name){
                    if($_FILES['content']['error'][$key] === 0){
                        $tmp_name = $_FILES['content']['tmp_name'][$key];
                        $unique_name = time() . "_" . $name;
                        $path = "uploads/policy/$unique_name";
                        move_uploaded_file($tmp_name, $path);
                        $this->policyModel->insert([
                            'id_tour' => $tour_id,
                            'content' => $path
                        ]);
                    }
                }
            }

            // 6. Lưu dịch vụ
            if(!empty($_POST['name_supplier'])){
                $services = array_unique(array_map('trim', $_POST['name_supplier']));
                foreach($services as $service){
                    if($service !== ""){
                        $serviceName = trim($service);

                        // Tìm nhà cung cấp tương ứng
                        $supplierObj = $this->supplierModel->getByServiceName($serviceName);
                        $idSupplier = $supplierObj ? $supplierObj->id : null;

                        if ($idSupplier) {
                            $this->toursupplierModel->insert([
                                'id_tour'      => $tour_id,
                                'type_service' => $serviceName,
                                'id_supplier'  => $idSupplier
                            ]);
                        } else {
                            // Nếu không tìm thấy supplier, log hoặc thông báo
                            // echo "Không tìm thấy nhà cung cấp cho dịch vụ: $serviceName";
                        }
                    }
                }
            }

            // 7. Thông báo thành công
            echo "<script>alert('Tạo tour thành công!'); window.location.href='?action=tour_manager_content';</script>";
            exit();
        } else {
            $success = "Tạo tour thất bại!";
        }
    }

    // Load view thêm tour
    include 'views/admin/tour_manager/add_tour.php';
}


function delete_tour($id){  
    $bookedTours = $this->booktourModel->getidbooking();                  // lấy toàn bộ id của bảng book tour để so sánh
    $notification="";     //thông báo lỗi
    $error = "";
    $success = "";
    // 1. Lấy đối tượng tour
    $tourObject = $this->tourModel->find_tour($id);
    if (!$tourObject) {
        $error = "Tour không thể xóa ";
        $list = $this->tourModel->all();
        include __DIR__ . '/../views/admin/tour_manager/tour_manager_content.php';
        return;
    }

    $tour_id = $tourObject->id;

    // 3. Xóa địa chỉ liên quan
    if(method_exists($this->addressModel,'delete_address')){
        $res = $this->addressModel->delete_address($tour_id);
        if(!$res) $error .= " Xóa địa chỉ thất bại.";
    }

    // 4. Xóa ảnh tour (file + DB)
    if(method_exists($this->imgtourModel,'get_img_tour') && method_exists($this->imgtourModel,'delete_img_tour')){
        $images = $this->imgtourModel->get_img_tour($tour_id); 
        if(!empty($images)){
            foreach($images as $img){
                $file_path = __DIR__ . '/../uploads/images/' . $img;
                if(file_exists($file_path) && !unlink($file_path)){
                    $error .= " Xóa file ảnh $img thất bại.";
                }
            }
        }
        if(!$this->imgtourModel->delete_img_tour($tour_id)) $error .= " Xóa bản ghi ảnh thất bại.";
    }

    // 5. Xóa chính sách liên quan
    if(method_exists($this->policyModel,'get_policy') && method_exists($this->policyModel,'delete_policy')){
        $policies = $this->policyModel->get_policy($tour_id);
        if(!empty($policies)){
            foreach($policies as $policy){
                if(!empty($policy['img'])){
                    $file_path = __DIR__ . '/../uploads/policy/' . $policy['img'];
                    if(file_exists($file_path) && !unlink($file_path)){
                        $error .= " Xóa file policy $policy[img] thất bại.";
                    }
                }
            }
        }
        if(!$this->policyModel->delete_policy($tour_id)) $error .= " Xóa bản ghi policy thất bại.";
    }

    // 6. Xóa nhà cung cấp liên quan
    if(method_exists($this->toursupplierModel,'delete_tour_supplier')){
        if(!$this->toursupplierModel->delete_tour_supplier($tour_id)) $error .= " Xóa nhà cung cấp thất bại.";
    }

    // 7. Xóa tour với try-catch
    try {
        if(method_exists($this->tourModel,'delete_tour')){
            $this->tourModel->delete_tour($tour_id);
            $success = "Xóa tour thành công!";
        }
    } catch (PDOException $e) {
        $error .= " Xóa tour thất bại đang có booking tour ";
    }

    // 8. Load lại danh sách tour
    $list = $this->tourModel->all();
    include __DIR__ . '/../views/admin/tour_manager/tour_manager_content.php';
}

public function tour_detail($id)
{
    // Lấy dữ liệu hiện tại
    $tour_detail        = $this->tourModel->find_tour($id);
    $list_tour_type     = $this->tourtypeModel->all();
    $addresses          = $this->addressModel->find_address($id);
    $policies           = $this->policyModel->find_policy($id);
    $tour_supplier      = $this->toursupplierModel->find_tour_supplier($id);
    $list_tour_supplier = $this->toursupplierModel->all();

    // Ảnh lấy từ tour_detail->images (đúng với VIEW)
    $images = $tour_detail->images;

    if (isset($_POST['update'])) {
        $tour_detail->name             = trim($_POST['name']);
        $tour_detail->price            = floatval($_POST['price']);
        $tour_detail->number_of_days       = intval($_POST['number_of_days']);
        $tour_detail->number_of_nights = intval($_POST['number_of_nights']);
        $tour_detail->scope            = intval($_POST['scope']);
        $tour_detail->describe         = trim($_POST['describe']);
        $tour_detail->date             = $_POST['date'];
        $tour_detail->id_tourtype      = $_POST['id_tourtype'];
        $tour_detail->status           = $_POST['status'];

        $this->tourModel->update_tour($tour_detail);

        // Kiểm tra có upload ảnh mới hay không
        $hasNewImage = false;
        if (!empty($_FILES['new_images']['error'])) {
            foreach ($_FILES['new_images']['error'] as $err) {
                if ($err === 0) {
                    $hasNewImage = true;
                    break;
                }
            }
        }

        if ($hasNewImage) {

            // XÓA ẢNH CŨ
            foreach ($images as $imgPath) {
                $filePath = __DIR__ . '/../' . $imgPath;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $this->imgtourModel->delete_img_tour($id);

            // UPLOAD ẢNH MỚI
            foreach ($_FILES['new_images']['name'] as $key => $name) {
                if ($_FILES['new_images']['error'][$key] === 0) {

                    $tmp = $_FILES['new_images']['tmp_name'][$key];
                    $unique = time() . "_" . $name;
                    $path = "uploads/tour/$unique";

                    move_uploaded_file($tmp, $path);

                    // Lưu DB
                    $this->imgtourModel->insert([
                        'tour_id'    => $id,
                        'image_path' => $path
                    ]);
                }
            }
        }

        if (!empty($_POST['address'])) {
            $this->addressModel->delete_address($id);

            foreach ($_POST['address'] as $addr) {
                $addr = trim($addr);
                if ($addr !== "") {
                    $this->addressModel->insert([
                        'id_tour' => $id,
                        'name'    => $addr,
                        'status'  => 1
                    ]);
                }
            }
        }


        if (!empty($_FILES['content']['name'])) {
            foreach ($_FILES['content']['name'] as $key => $name) {
                if ($_FILES['content']['error'][$key] === 0) {
                    $tmp = $_FILES['content']['tmp_name'][$key];
                    $unique = time() . "_" . $name;
                    $uploadDir = __DIR__ . '/../uploads/policy/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    $path = $uploadDir . $unique;

                    if (move_uploaded_file($tmp, $path)) {
                        $relativePath = "uploads/policy/" . $unique; // lưu vào DB
                        if (!empty($_POST['policy_id'][$key])) {
                            // xóa file cũ
                            $oldFile = __DIR__ . '/../' . $policies[$key]['content'];
                            if (file_exists($oldFile)) unlink($oldFile);

                            // update DB
                            $this->policyModel->update_policy($_POST['policy_id'][$key], $relativePath);
                        } else {
                            // thêm mới
                            $this->policyModel->insert([
                                'id_tour' => $id,
                                'content' => $relativePath
                            ]);
                        }
                    } else {
                        $error .= " Upload file $name thất bại.";
                    }
                }
            }
        }


        if (!empty($_POST['type_service'])){

            $this->toursupplierModel->delete_tour_supplier($id);

            foreach ($_POST['type_service'] as $srvID) {
                $srvObj = $this->toursupplierModel->getById($srvID);

                if ($srvObj) {
                    $this->toursupplierModel->insert([
                        'id_tour'      => $id,
                        'type_service' => $srvObj->type_service,
                        'id_supplier'  => $srvObj->id_supplier ?? null
                    ]);
                }
            }
        }

        echo "<script>alert('Cập nhật tour thành công!'); window.location.href='?action=tour_manager_content';</script>";
        exit();
    }

    include 'views/admin/tour_manager/tour_detail.php';
}




function search_tour(){
        // Xử lý tìm kiếm
        $bookedTours = $this->booktourModel->getidbooking(); // biến lấy toàn bộ danh id trong bảng book tour để sa sánh
        $result=[];
        $notification="";
        $list = $this->tourModel->all();
        if(isset($_GET['search_tour'])){
            $key_word = trim($_GET['key_word']);
            if($key_word === ""){
                $notification = "Bạn chưa nhập dữ liệu";
            } else {
                $result = [];
                foreach($list as $tt){
                    if(stripos($tt->name, $key_word) !== false){
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
        include 'views/admin/tour_manager/tour_manager_content.php';
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


    // ===========================      quản lý đặt tour     ===================================

    function booking_content(){
        $notification="";
        $sql = "SELECT t.*, i.img AS image                                     
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE t.status = 1
                    ORDER BY t.id, i.id";
        $list_tour = $this->tourModel->tour_status($sql);

        include 'views/admin/booking_manager/booking_content.php';
    }


    function search_booking_tour(){
        // Xử lý tìm kiếm
        $bookedTours = $this->booktourModel->getidbooking(); // biến lấy toàn bộ danh id trong bảng book tour để sa sánh
        $result=[];
        $notification="";
        $list = $this->tourModel->all();
        if(isset($_GET['search_booking_tour'])){
            $key_word = trim($_GET['key_word']);
            if($key_word === ""){
                $notification = "Bạn chưa nhập dữ liệu";
            } else {
                $result = [];
                foreach($list as $tt){
                    if(stripos($tt->name, $key_word) !== false){
                        $result[] = $tt;
                    }
                }

                if(empty($result)){
                    $notification = "Không tìm thấy kết quả";
                } else {
                    $list = $result; // gán kết quả tìm được
                }
                header("Location:?action=booking_content");
            }
        }
        include 'views/admin/booking_manager/booking_content.php';
    }

}
 







