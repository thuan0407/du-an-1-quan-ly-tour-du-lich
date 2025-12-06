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
        $tour->number_of_days   = intval($_POST['number_of_days'] ?? 0);
        $tour->number_of_nights = intval($_POST['number_of_nights'] ?? 0);
        $tour->scope            = intval($_POST['scope'] ?? 0);
        $tour->describe         = trim($_POST['describe'] ?? '');
        $tour->status           = 1;
        $tour->type_tour        = $_POST['type_tour'];
        $tour->date             = date("Y-m-d");
        $tour->id_tourtype      = $_POST['id_tourtype'] ?? null;
        $tour->type_tour        = $_POST['type_tour'] ?? 1;
        $tour->location        = $_POST['type_tour'] ?? 1;

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
            $titles = $_POST['title'] ?? [];
            $contents = $_POST['content'] ?? [];

            for ($i = 0; $i < count($contents); $i++) {

                // Nếu cả tiêu đề và nội dung đều trống thì bỏ qua
                if (empty(trim($titles[$i])) && empty(trim($contents[$i]))) continue;

                $this->policyModel->insert([
                    'id_tour' => $tour_id,
                    'title'   => trim($titles[$i]),
                    'content' => trim($contents[$i])
                ]);
            }

            //lịch khởi hành từng ngày
            $contents = $_POST['detailed_content_every_day'];
            foreach ($contents as $content) {
                if (empty(trim($content))) continue;
                $detail = [
                    'id_tour' => $tour_id,
                    'content' => $content
                ];
                $this->scheduledetailsModel->addDailyPlan($detail);
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

    // 7. Xóa lịch trình từng ngày
    if (method_exists($this->scheduledetailsModel, 'delete_daily')) {
        $this->scheduledetailsModel->delete_daily($tour_id);
    }

    // 8. Xóa tất cả policy thuộc tour
    if (method_exists($this->policyModel, 'delete_policy')) {
        $this->policyModel->delete_policy($tour_id);
    }
    $success = "Xóa tour thành công!";

    // 8. Xóa tour với try-catch
    try {
        if(method_exists($this->tourModel,'delete_tour')){
            $this->tourModel->delete_tour($tour_id);
            $success = "Xóa tour thành công!";
        }
    } catch (PDOException $e) {
        $error .= " Xóa tour thất bại đang có booking tour ";
    }

    // 9. Load lại danh sách tour
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

        $currentServices = array_map(function($s){ return $s['id']; }, $tour_supplier);
        $newServices = array_map('intval', $_POST['type_service'] ?? []);   //Đảm bảo $newServices từ form là mảng số nguyên

        // Xóa những dịch vụ không còn trong form
        $toDelete = array_diff($currentServices, $newServices);
        foreach ($toDelete as $delID) {
            $this->toursupplierModel->delete_by_service_id($id, $delID);
        }
        // Thêm những dịch vụ mới
        $toAdd = array_diff($newServices, $currentServices);
        foreach ($toAdd as $srvID) {
            $srvObj = $this->toursupplierModel->getById($srvID);
            if ($srvObj) {
                $this->toursupplierModel->insert([
                    'id_tour'      => $id,
                    'type_service' => $srvObj->type_service,
                    'id_supplier'  => $srvObj->id_supplier ?? null
                ]);
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

    function booking_tour(){
        $notification="";
        $sql = "SELECT t.*, i.img AS image                                     
                    FROM `tour` t
                    LEFT JOIN img_tour i ON t.id = i.id_tour
                    WHERE t.status = 1
                    ORDER BY t.id, i.id";
        $list_tour = $this->tourModel->tour_status($sql);

        include 'views/admin/booking_manager/book_individual_tours/content.php';
    }


    function search_booking_tour(){
    $result = [];
    $notification = "";
    $list_tour = $this->tourModel->all();

    if(isset($_GET['search_booking_tour'])){
        
        $key_word = trim($_GET['key_word']);

        if($key_word === ""){
            $notification = "Bạn chưa nhập dữ liệu";
        } else {

            foreach($list_tour as $tt){
                if(stripos($tt->name, $key_word) !== false){
                    $result[] = $tt;
                }
            }

            if(empty($result)){
                $notification = "Không tìm thấy kết quả";
            } else {
                $list_tour = $result;
            }
        }
    }

    include 'views/admin/booking_manager/book_individual_tours/content.php';
}

    function booking_individual_tours_detail($id){
        $tour              = $this->tourModel->find_tour($id);                         //lấy tour tương ứng với id
        $tour_img          = $this->imgtourModel->get_img_tour($id);                   //lấy ảnh tour ở dạng một chiều

        $address           = $this->addressModel->get_address($id);                    // lấy địa điểm của tour ở dạng mảng một chiều
        $tour_supplier     = $this->toursupplierModel->find_tour_supplier($id);        // lấy danh sach loại dịch vụ

        $id_tourtype       = $tour->id_tourtype;
        $tour_type         = $this->tourtypeModel->find_tour_type($id_tourtype);       // loại tour

        $type_guide        = $tour->type_tour;
        $list_guide        = $this->tourguideModel->get_type_guide($type_guide);        // Danh sách hướng dẫn viên lọc theo id khu vực

        $contract           = new Contract();
        $book_tour          = new Book_tour();
        $customer_list      = new Customer_list();
        $departure_schedule = new Departure_schedule();
        $pay                = new Pay();
        $special_request    = new Special_request();

        if(isset($_POST['order_tour'])){
            //---- Tạo lịch khởi hành ----//
            $departure_schedule->start_date       = $_POST['start_date'];
            $departure_schedule->end_date         = $_POST['end_date'];
            $departure_schedule->start_location   = $_POST['start_location'];
            $departure_schedule->end_location     = $_POST['end_location'];
            $departure_schedule->note             = $_POST['departure_schedule_note'] ?? '';
            $departure_schedule->id_tour_guide    = $_POST['tour_guide_id'];
            $departure_schedule->status           = 1;

            $departureschedule_id = $this->departurescheduleModel->create($departure_schedule);

            //---- Lưu chi tiết lịch khởi hành --------//
            $days     = $_POST['details_every_day'];          // mảng ngày dạng 'YYYY-MM-DD'
            $contents = $_POST['detailed_content_every_day']; // mảng nội dung

            for ($i = 0; $i < count($days); $i++) {
                if (empty(trim($days[$i])) || empty(trim($contents[$i]))) continue;

                $detail = [
                    'id_departure_schedule' => $departureschedule_id,
                    'date'                  => $days[$i],   // lưu ngày
                    'content'               => $contents[$i]
                ];

                $this->departurescheduledetailsModel->addDailyPlan($detail);
            }

            //---- Tạo booking ----//
            $book_tour->date                    = date("Y-m-d");
            $book_tour->total_amount            = $_POST['total_amount'];
            $book_tour->note                    = $_POST['departure_schedule_note'] ?? '';
            $book_tour->status                  = 2;
            $book_tour->quantity                = $_POST['quantity'];
            $book_tour->id_departure_schedule   = $departureschedule_id;
            $book_tour->id_tour_guide           = $_POST['tour_guide_id'];
            $book_tour->id_tour                 = $id;
            $book_tour->number_of_days          = $_POST['number_of_days'];
            $book_tour->number_of_nights        = $_POST['number_of_nights'];
            $book_tour->phone                   = $_POST['phone'];
            $book_tour->customername            = $_POST['customername'];

            $book_tour_id = $this->booktourModel->create($book_tour);

            //---- Lưu danh sách khách ----//
            if(isset($_FILES['list_customer']) && $_FILES['list_customer']['size'] > 0){
                $file = $_FILES['list_customer'];
                $unique = time() . "_" . $file['name'];
                $uploadDir = __DIR__ . '/../uploads/list_customer/';
                $path = $uploadDir . $unique;
                move_uploaded_file($file['tmp_name'], $path);

                $customer_list->list_customer = "uploads/list_customer/" . $unique;
                $customer_list->quantity      = $_POST['quantity'];
                $customer_list->note          = $_POST['note_customer'];
                $customer_list->id_book_tour  = $book_tour_id;

                $this->customerlistModel->create($customer_list);
            }

            //---- Lưu hợp đồng ----//
            if(isset($_FILES['content_contract']) && $_FILES['content_contract']['size'] > 0){
                $fileContract = $_FILES['content_contract'];
                $uniqueContract = time() . "_" . $fileContract['name'];
                $uploadDirContract = __DIR__ . '/../uploads/contract/';
                $pathContract = $uploadDirContract . $uniqueContract;
                move_uploaded_file($fileContract['tmp_name'], $pathContract);

                $contract->name          = $_POST['name_contract'];
                $contract->date          = date("Y-m-d");
                $contract->status        = 1;
                $contract->value         = $_POST['value_contract'];
                $contract->content       = "uploads/contract/" . $uniqueContract;
                $contract->id_book_tour  = $book_tour_id;

                $this->contractModel->create($contract);
            }

            // ------ Tạo thanh toán ------- //
            $pay ->date                  = date("Y-m-d");
            $pay ->payment_method        = $_POST['payment_method'];
            $pay ->amount_money          = $_POST['amount_money'];
            $pay ->note                  = $_POST['pay_note'];
            if($pay->amount_money == $book_tour->total_amount){      // kiểm tra thanh toán 
                $pay ->status  = 2;
            }else{
                $pay ->status = 1;
            }
            $pay ->id_book_tour          = $book_tour_id;

            $this->payModel->create($pay);   
            
            // ------ Tạo yêu cầu đặc biệt
            $special_request->date             = date("Y-m-d");
            $special_request->content          = $_POST['content_spceail'];
            $special_request->status           = 1;
            $special_request->id_book_tour     = $book_tour_id;  
            
            $this->specialrequestModel->create($special_request);

           $success = "Đặt tour thành công!";

        }

        include 'views/admin/booking_manager/book_individual_tours/detail.php';
    }


// ==================================================================================


    function waiting_for_approval(){                                               // tour chờ duyệt  
        $notification="";
        $status = 1;
        $list_book_tour = $this->booktourModel->get_book_tour_all($status);        // lấy tất cả tour đang hoạt động

        include 'views/admin/booking_manager/waiting_for_approval/content.php';
    }

    function waiting_for_approval_detail($id){                                               // tour chờ duyệt chi tiết 
        $notification="";
        $status = 1;
        
        $book_tour         = $this->booktourModel->get_book_tour($id);                      // lấy tour chờ duyệt

        $id_tour           = $book_tour->id_tour;
        $tour              = $this->tourModel->find_tour($id_tour);                         //lấy tour tương ứng với id

        $id_tourtype       = $tour->id_tourtype;
        $tour_type         = $this->tourtypeModel->find_tour_type($id_tourtype);        //Lất loại tour 

        $address           = $this->addressModel->get_address($id_tour);                // lấy địa điểm của tour ở dạng mảng một chiều
        $tour_supplier     = $this->toursupplierModel->find_tour_supplier($id_tour);    // lấy danh sach loại dịch vụ của tour

        $type_guide        = $tour->type_tour;
        $list_guide        = $this->tourguideModel->get_type_guide($type_guide);        // Danh sách hướng dẫn viên lọc theo id khu vực

        $contract           = new Contract();
        $customer_list      = new Customer_list();
        $departure_schedule = new Departure_schedule();
        $pay                = new Pay();
        $special_request    = new Special_request();

        if(isset($_POST['browse_tours'])){
            //---- Tạo lịch khởi hành ----//
            $departure_schedule->start_date       = $_POST['start_date'];
            $departure_schedule->end_date         = $_POST['end_date'];
            $departure_schedule->start_location   = $_POST['start_location'];
            $departure_schedule->end_location     = $_POST['end_location'];
            $departure_schedule->note             = $_POST['departure_schedule_note'] ?? '';
            $departure_schedule->id_tour_guide    = $_POST['tour_guide_id'];
            $departure_schedule->status           = 1;

            $departureschedule_id = $this->departurescheduleModel->create($departure_schedule);

            //---- Lưu chi tiết lịch khởi hành --------//
            $days     = $_POST['details_every_day'];          // mảng ngày dạng 'YYYY-MM-DD'
            $contents = $_POST['detailed_content_every_day']; // mảng nội dung

            for ($i = 0; $i < count($days); $i++) {
                if (empty(trim($days[$i])) || empty(trim($contents[$i]))) continue;

                $detail = [
                    'id_departure_schedule' => $departureschedule_id,
                    'date'                  => $days[$i],   // lưu ngày
                    'content'               => $contents[$i]
                ];

                $this->departurescheduledetailsModel->addDailyPlan($detail);
            }

            //---- update booking ----//
            $book_tour->date                    = date("Y-m-d");
            $book_tour->total_amount = str_replace('.', '', $_POST['total_amount']);    // cuyển về dạng số
            $book_tour->note                    = $_POST['departure_schedule_note'] ?? '';
            $book_tour->status                  = 2;
            $book_tour->quantity                = $_POST['quantity'];
            $book_tour->id_departure_schedule   = $departureschedule_id;
            $book_tour->id_tour_guide           = $_POST['tour_guide_id'];
            $book_tour->number_of_days          = $_POST['number_of_days'];
            $book_tour->number_of_nights        = $_POST['number_of_nights'];
            $book_tour->phone                   = $_POST['phone'];
            $book_tour->customername            = $_POST['customername'];
            

             $this->booktourModel->update_book_tour($book_tour);

            //---- Lưu danh sách khách ----//
            if(isset($_FILES['list_customer']) && $_FILES['list_customer']['size'] > 0){
                $file = $_FILES['list_customer'];
                $unique = time() . "_" . $file['name'];
                $uploadDir = __DIR__ . '/../uploads/list_customer/';
                $path = $uploadDir . $unique;
                move_uploaded_file($file['tmp_name'], $path);

                $customer_list->list_customer = "uploads/list_customer/" . $unique;
                $customer_list->quantity      = $_POST['quantity'];
                $customer_list->note          = $_POST['note_customer'];
                $customer_list->id_book_tour  = $book_tour->id;

                $this->customerlistModel->create($customer_list);
            }

            //---- Lưu hợp đồng ----//
            if(isset($_FILES['content_contract']) && $_FILES['content_contract']['size'] > 0){
                $fileContract = $_FILES['content_contract'];
                $uniqueContract = time() . "_" . $fileContract['name'];
                $uploadDirContract = __DIR__ . '/../uploads/contract/';
                $pathContract = $uploadDirContract . $uniqueContract;
                move_uploaded_file($fileContract['tmp_name'], $pathContract);

                $contract->name          = $_POST['name_contract'];
                $contract->date          = date("Y-m-d");
                $contract->status        = 1;
                $contract->value         = $_POST['value_contract'];
                $contract->content       = "uploads/contract/" . $uniqueContract;
                $contract->id_book_tour  = $book_tour->id;

                $this->contractModel->create($contract);
            }

            // ------ Tạo thanh toán ------- //
            $pay ->date                  = date("Y-m-d");
            $pay ->payment_method        = $_POST['payment_method'];
            $pay ->amount_money          = $_POST['amount_money'];
            $pay ->note                  = $_POST['pay_note'];
            $pay ->id_book_tour          = $book_tour->id;
            if($pay->amount_money == $book_tour->total_amount){      // kiểm tra thanh toán 
                $pay ->status  = 2;
            }else{
                $pay ->status = 1;
            }

            $this->payModel->create($pay);   
            
            // ------ Tạo yêu cầu đặc biệt
            $special_request->date             = date("Y-m-d");
            $special_request->content          = $_POST['content_spceail'];
            $special_request->status           = 1;
            $special_request->id_book_tour     = $book_tour->id;  
            
            $this->specialrequestModel->create($special_request);

           $success = "Duyệt tour thành công!";

        }

        include 'views/admin/booking_manager/waiting_for_approval/detail.php';
    }

    function waiting_for_approval_delete($id){       //xóa tour chờ duyệt
        $success ="";
        $error ="";
        if(empty($id)){
            echo "tour này không tồn tại!";
        }else{
            $result =$this->booktourModel->delete_book_tour($id);
            if($result ==1){
                header("Location:?action=waiting_for_approval&msg=success");
                exit();
            }
            else{
                header("Location:?action=waiting_for_approval&msg=error");
                exit();
            }
        }
        }

    function tour_is_active(){                                                     // tour đang hoạt động               
        $notification="";
        $status = 2;
        $list_book_tour = $this->booktourModel->get_book_tour_all($status);        // lấy tour đang hoạt động

        include 'views/admin/booking_manager/tour_is_active/content.php';
    }

    function tour_is_active_detail($id){
        $book_tour         = $this->booktourModel->get_book_tour($id);
        $id_tour           = $book_tour->id_tour;
        $tour              = $this->tourModel->find_tour($id_tour);                         //lấy tour tương ứng với id

        $id_tourtype       = $tour->id_tourtype;
        $tour_type         = $this->tourtypeModel->find_tour_type($id_tourtype);        //Lấy loại tour 

        $address           = $this->addressModel->get_address($id_tour);                // lấy địa điểm của tour ở dạng mảng một chiều
        $tour_supplier     = $this->toursupplierModel->find_tour_supplier($id_tour);    // lấy danh sach loại dịch vụ của tour

        $type_guide        = $tour->type_tour;
        $list_guide        = $this->tourguideModel->get_type_guide($type_guide);        // Danh sách hướng dẫn viên lọc theo id khu vực

        $id_tour_guide     = $book_tour->id_tour_guide;                          
        $tour_guide        = $this->tourguideModel->find_tour_guide($id_tour_guide);

        $pay               = $this->payModel->get_pay($book_tour->id);              //bảng thanh toán

        $id_departure_schedule = $book_tour->id_departure_schedule;                      
        $departure_schedule    = $this->departurescheduleModel->get_departure_schedule($id_departure_schedule);  // lấy lịch khởi hành

        $list_departure_schedule_details = $this->departurescheduledetailsModel->get_all_departure_schedule_details($id_departure_schedule);  //danh sách lịch khởi hành           // lấy lịch khởi hành chi tiết

        $list_special_request  = $this->specialrequestModel->get_special_request_list($book_tour->id);             // lấy danh sách yêu cầu đặc biệt
        
        $step      = $departure_schedule->status; 
        $arr1      = ["Chuẩn bị khởi hành","Khỏi hành"];//điểm khởi hành
        $arr2      = $address;
        $arr3      = ["Kết thúc"];// điểm kết thúc

        $arr_merged = array_merge($arr1, $arr2, $arr3);

            if(isset($_POST['cancel'])){
            $amount_money = isset($_POST['amount_money_pay']) ? floatval($_POST['amount_money_pay']) : 0;
            if ($amount_money < 0 || $amount_money > 99999999.99) {
                echo "Giá trị thanh toán không hợp lệ!";
                return;
            }
            $update_pay                        = $this->payModel->amount_money_pay($pay->id, $amount_money);              //update lại bảng pay
            $delete_contract                   =  $this->contractModel->delete_contract($book_tour->id);                             //xóa bảng hợp đồng
            $customer_list                     =  $this->customerlistModel->delete_customer_list($book_tour->id);                        //xóa bảng danh sách khách
            $delete_special_request            =  $this->specialrequestModel->delete_special_request($book_tour->id);                                           //xóa yêu cầu đặc biệt
            $delete_departure_schedule_details =  $this->departurescheduledetailsModel->delete_departure_schedule_details($book_tour->id_departure_schedule);  //xóa chi tiết lịch khởi hành

            $book_tour_status      = 4;
            $update_book_tour      =$this->booktourModel->update_book_tour_status($id, $book_tour_status);         //update lại bảng book tour

            if($delete_contract>0 && $customer_list>0 && $delete_special_request>0 && $delete_departure_schedule_details>0 && $update_book_tour>0){
                header("Location:?action=tour_is_active&msg=success");
            }else{
                header("Location:?action=tour_is_active&msg=error");
            }

        }


        include 'views/admin/booking_manager/tour_is_active/detail.php';
    }

    //================code của tùng====================================

     function tour_has_ended() {
        $notification = "";

        // CHỈ LẤY TOUR CÓ BOOKING STATUS = 3 (đã kết thúc)
        $sql = "SELECT t.*, i.img AS image
                FROM tour t
                JOIN book_tour bt ON bt.id_tour = t.id
                LEFT JOIN img_tour i ON t.id = i.id_tour
                WHERE bt.status = 3
                AND DATE_ADD(t.date, INTERVAL t.number_of_days DAY) < CURDATE()
                GROUP BY t.id
                ORDER BY t.date DESC";

        $tours = $this->tourModel->tour_status($sql);

            // Gắn thông tin thanh toán cho từng tour
        foreach ($tours as $tour) {
            // Tổng tiền của các booking (book_tour.total_amount) status = 3
            $revenue = $this->booktourModel->getRevenueForTour($tour->id, 3);

            // Tổng số tiền đã thu (pay.amount_money) của các booking status = 3
            $paid    = $this->payModel->getPaidAmountForTour($tour->id, 3);

            // Còn nợ = doanh thu - đã thu, không cho âm
            $debt = max($revenue - $paid, 0);

            // Gắn vào object để view dùng
            $tour->tong_doanh_thu = $revenue;
            $tour->da_thu         = $paid;
            $tour->con_no         = $debt;
        }
         include 'views/admin/booking_manager/tour_has_ended/content.php';
    }



public function tour_detail_view($id_lich_trinh)
{
    // Lấy thông tin tour đã kết thúc
    $tour = $this->tourModel->get_tour_ended_detail($id_lich_trinh);

    if (!$tour) {
        die("Không tìm thấy tour đã kết thúc với id = " . (int)$id_lich_trinh);
    }

    // ===== LẤY HƯỚNG DẪN VIÊN CHO TOUR NÀY =====
    // Dựa trên các booking trong book_tour
    $guide = $this->booktourModel->getGuideForTour($tour->id);

    // ===== TÍNH TỔNG DOANH THU & ĐÃ THU CHO TOUR NÀY =====
    // status = 3: đã kết thúc
    $doanh_thu = $this->booktourModel->getRevenueForTour($tour->id, 3);
    $da_thu    = $this->payModel->getPaidAmountForTour($tour->id, 3);

    // Gắn vào object $tour để view dùng
    $tour->tong_tien_don_hang = $doanh_thu;   // Tổng doanh thu
    $tour->tong_thuc_thu      = $da_thu;      // Đã thu
    $tour->incidental_costs   = 0;            // Tạm thời chưa có cột chi phí phát sinh

    // Gọi view
    include 'views/admin/booking_manager/tour_has_ended/tour_detail_view.php';
}



    function tour_canceled() {
        // 1. Gọi Model để lấy danh sách Tour đã hủy (status = 4)
        // Lưu ý: Biến view của bạn tên là $tours, nên ở đây mình đặt là $tours cho khớp
        // $tours = $this->tourModel->get_tours_by_status(4); 
        $tours = $this->tourModel->get_canceled_tours_detail();
        
        // 2. Load View
        include 'views/admin/booking_manager/tour_canceled/tour_canceled.php';
    }

        // Đánh dấu 1 tour đã thanh toán đủ
    public function mark_tour_paid($id)
    {
        $tourId = (int)$id;

        // 1. Lấy tất cả booking của tour này đã kết thúc (status = 3)
        $bookings = $this->booktourModel->getBookingsByTourAndStatus($tourId, 3);

        foreach ($bookings as $bk) {
            $bookingId = (int)$bk->id;
            $tong      = (float)$bk->total_amount;

            // Đã thu cho từng booking
            $daThu  = $this->payModel->getPaidAmountByBooking($bookingId);
            $conNo  = $tong - $daThu;

            // Nếu còn nợ > 0 thì tạo thêm 1 bản ghi pay để bù cho đủ
            if ($conNo > 0.00001) {
                $this->payModel->createAutoPayment(
                    $bookingId,
                    $conNo,
                    'Auto: Đánh dấu đã tour đã được thanh toán'
                );
            }
        }

        // Quay lại trang chi tiết tour
        header("Location: ?action=tour_detail_view&id=" . $tourId);
        exit;
    }

}
 







