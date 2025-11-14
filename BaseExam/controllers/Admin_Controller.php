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


    function tour_catalog_management(){           //quản lý danh mục tour
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
    function human_resource_management(){
        $list =$this->tourguideModel->all();
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
function tour_guide_detail($id){
    $object = $this->tourguideModel->find($id);   //tìm trả về một đối tượng hướng dẫn viên    
    include 'views/admin/human_resource_management.php';
}



}
