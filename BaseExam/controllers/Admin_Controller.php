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

   /////////////////////////////////// /////////////////////////              //quản lý danh mục tour
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
                    $success ="create thành công";
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
            $success ="xóa thành công";
            header("Location: ?action=tour_catalog_management");
        }
        else{
            $err ="thất bại";
            header("Location: ?action=tour_catalog_management");
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
            header("Location: ?action=tour_catalog_management&msg=update_success");
        } else {
            header("Location: ?action=tour_catalog_management&msg=update_error");
        }
        exit;
    }
    }

    ///////////////////////////////////////////////////////// quản lý nhân sự
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
                        header("Location: ?action=human_resource_management&msg=update_success");
                        exit;
                    } else {
                    header("Location: ?action=human_resource_management&msg=update_error");
                    exit;
                }

            }
        }
        include 'views/admin/human_resource_management.php';

    }

    function add_tour_guide(){                                     //thêm thướng dẫn viên
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
                            header("Location: ?action=human_resource_management&msg=create_success");
                            exit;
                        } else {
                        header("Location: ?action=human_resource_management&msg=create_error");
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



////////////////////////////////////////////////////////////////////////////         quản lý tour
    function tour_manager(){
        $list = $this-> tourModel->all();
        $list_tour_type = $this->tourtypeModel->all();
        $list_tour_supplier = $this-> toursupplierModel->all();
        include 'views/admin/tour_manager.php';
    }

    public function add_tour() {
    if (!isset($_POST['create_tour'])) return;

    $tourModel = new Tour_Model();
    $imgModel = new Img_tour_Model();
    $addressModel = new Address_Model();
    $policyModel = new Policy_Model();
    $supplierModel = new Tour_supplier_Model();

    // đảm bảo thư mục tồn tại
    if (!is_dir("uploads/tour/")) mkdir("uploads/tour/", 0777, true);
    if (!is_dir("uploads/policy/")) mkdir("uploads/policy/", 0777, true);

    $tour = [
        'name' => $_POST['name'],
        'describe' => $_POST['describe'],
        'number_day' => $_POST['number_day'],
        'price' => $_POST['price'],
        'id_tourtype' => $_POST['id_tourtype'], // sửa đúng
        'scope' => $_POST['scope'],
        'number_of_nights' => $_POST['number_of_nights'],
        'date' => date("Y-m-d"),
        'id_user' => $_SESSION['user']['id'] // lấy từ session
    ];

    $tour_id = $tourModel->insert($tour);

    // lưu ảnh
    for ($i = 0; $i < count($_FILES['img']['name']); $i++) {
        $fileName = time() . "_" . $_FILES['img']['name'][$i];
        move_uploaded_file($_FILES['img']['tmp_name'][$i], "uploads/tour/" . $fileName);

        $imgModel->insert([
            'img' => $fileName,
            'id_tour' => $tour_id
        ]);
    }

    // lưu địa điểm
    foreach ($_POST['address'] as $addr) {
        $addressModel->insert([
            'name' => $addr,
            'status' => 1,
            'id_tour' => $tour_id
        ]);
    }

    // lưu chính sách
    for ($i = 0; $i < count($_FILES['policy']['name']); $i++) {
        $fileName = time() . "_" . $_FILES['policy']['name'][$i];
        move_uploaded_file($_FILES['policy']['tmp_name'][$i], "uploads/policy/" . $fileName);

        $policyModel->insert([
            'type_policy' => "file",
            'content' => $fileName,
            'id_tour' => $tour_id
        ]);
    }

    // lưu dịch vụ
    foreach ($_POST['id_tour'] as $service_id) {
        $supplierModel->insert([
            'type_service' => null,
            'id_supplier' => $service_id,
            'id_tour' => $tour_id
        ]);
    }

    header("Location: ?action=tour_manager");
}

function delete_tour($id){
      // 1. Lấy đối tượng tour
    $tourjbect = $this->tourModel->find_tour($id);

    $tour_id = $tourjbect->id;

     // 2. Xóa địa chỉ liên quan
    if(method_exists($this->addressModel,'delete_address')){
        $this->addressModel->delete_address($tour_id);
    }

    // 3. Xóa ảnh tour (cả file vật lý và bản ghi DB)
    if(method_exists($this->imgtourModel,'get_img_tour') && method_exists($this->imgtourModel,'delete_img_tour')){
        $images = $this->imgtourModel->get_img_tour($tour_id); // lấy mảng tên file ảnh
        if(!empty($images)){
            foreach($images as $img){
                $file_path = __DIR__ . '/../uploads/images/' . $img;
                if(file_exists($file_path)){
                    unlink($file_path); // xóa file vật lý
                }
            }
        }
        $this->imgtourModel->delete_img_tour($tour_id); // xóa bản ghi DB
    }

    // 4. Xóa chính sách liên quan (cả ảnh nếu có)
    if(method_exists($this->policyModel,'get_policy') && method_exists($this->policyModel,'delete_policy')){
        $policies = $this->policyModel->get_policy($tour_id); // lấy danh sách policy
        if(!empty($policies)){
            foreach($policies as $policy){
                // nếu policy có ảnh
                if(!empty($policy['img'])){ 
                    $file_path = __DIR__ . '/../uploads/policy/' . $policy['img'];
                    if(file_exists($file_path)){
                        unlink($file_path);
                    }
                }
            }
        }
        $this->policyModel->delete_policy($tour_id); // xóa bản ghi DB
    }

    // 5. Xóa nhà cung cấp liên quan
    if(method_exists($this->toursupplierModel,'delete_tour_supplier')){
        $this->toursupplierModel->delete_tour_supplier($tour_id);
    }

    // 6. Xóa tour
    if(method_exists($this->tourModel,'delete_tour')){
        $this->tourModel->delete_tour($tour_id);
    }

    // 7. Load lại danh sách tour để hiển thị
    $list = $this-> tourModel->all();
    include 'views/admin/tour_manager.php';
}
    
}

 







